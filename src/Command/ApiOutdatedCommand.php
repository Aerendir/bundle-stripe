<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Command;

use SerendipityHQ\Bundle\StripeBundle\SHQStripeBundle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\String\ByteString;

final class ApiOutdatedCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'stripe:api:outdated';

    /** @var int $return */
    private $return = self::SUCCESS;

    protected function configure(): void
    {
        $this
            ->setDescription('Checks API compatibility between Stripe, this bundle and your Symfony app.')
            ->addOption('skip-api', null, InputOption::VALUE_NONE, 'Do not check the implemented API is the last one released by Stripe.')
            ->addOption('skip-models', null, InputOption::VALUE_NONE, 'Do not check local and SDK models are in synch.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $ioWriter = new SymfonyStyle($input, $output);
        $ioWriter->title('Starting ' . self::$defaultName);

        false === (bool) $input->getOption('skip-api')
            ? $this->checkApiVersion($ioWriter)
            : $ioWriter->writeln('Skipping checking of API...');

        false === (bool) $input->getOption('skip-models')
            ? $this->checkLocalModelsHaveSdkModelsProperties($ioWriter)
            : $ioWriter->writeln('Skipping checking of models...');

        return $this->return;
    }

    private function checkApiVersion(SymfonyStyle $ioWriter): void
    {
        if (false === \class_exists(HttpClient::class)) {
            $ioWriter->error(\Safe\sprintf("The Symfony HTTP client doesn't exist and it is required to run this command.\nRun \"composer req symfony/http-client\" to install it."));
            $this->return = self::FAILURE;

            return;
        }

        if (false === \class_exists(Crawler::class)) {
            $ioWriter->error(\Safe\sprintf('The Symfony DomCrawler component is not installed and it is required to run this command.
Run "composer req symfony/domcrawler" to install it.'));
            $this->return = self::FAILURE;

            return;
        }

        $apiVersions            = $this->scrapeApiVersions($ioWriter);
        $supportedApiVersionKey = \array_search(SHQStripeBundle::SUPPORTED_STRIPE_API, $apiVersions);

        if (false === $supportedApiVersionKey) {
            $ioWriter->error(\Safe\sprintf("The supported API version %s seems not a valid one: it doesn't exist in Stripe documentation.", SHQStripeBundle::SUPPORTED_STRIPE_API));
            $this->return = self::FAILURE;

            return;
        }

        $ioWriter->writeln(\Safe\sprintf('Supported API Version: %s', SHQStripeBundle::SUPPORTED_STRIPE_API));
        $ioWriter->writeln(\Safe\sprintf('Last API Version: %s', $apiVersions[0]));

        if (0 !== $supportedApiVersionKey) {
            $ioWriter->error(\Safe\sprintf('The currently supported API version is %s versions behind the last released one.', $supportedApiVersionKey));
            $this->return = self::FAILURE;

            return;
        }

        $ioWriter->success(\Safe\sprintf('The currently supported API version is even with the last released one.'));
    }

    private function checkLocalModelsHaveSdkModelsProperties(SymfonyStyle $ioWriter): void
    {
        $localModelClasses = $this->getModelClasses();

        // This is not an SDK model classes, but it is used internally to manage Stripe's webhook
        unset($localModelClasses['StripeLocalWebhookEvent']);

        $sdkModelClasses = $this->guessSdkModelClassesFromLocalOnes($localModelClasses);

        $failures = [];
        foreach ($localModelClasses as $localModelName => $localModelClass) {
            $failures[] = $this->testLocalModelIsInSynchWithSdkModel($localModelClass, $sdkModelClasses[$localModelName]);
        }

        $failures = \array_merge(...$failures);
        if ( ! empty($failures)) {
            $ioWriter->error(\implode("\n", $failures));
            $this->return = self::FAILURE;

            return;
        }

        $ioWriter->success('Local model classes and SDK model classes are all in synch.');
    }

    /**
     * @return array<array-key,string>
     */
    private function scrapeApiVersions(SymfonyStyle $ioWriter): array
    {
        $client = HttpClient::create();

        $ioWriter->writeln('Calling https://stripe.com/docs/upgrades ...');
        $response = $client->request('GET', 'https://stripe.com/docs/upgrades');

        $statusCode = $response->getStatusCode();
        $ioWriter->writeln(\Safe\sprintf('Status code returned: %s', $statusCode));

        $html = $response->getContent();

        $crawler = new Crawler($html);

        $apiChangelogNode = $crawler->filter('h2#api-changelog');

        $apiChangelogValues = $apiChangelogNode->siblings()->each(static function (Crawler $node) {
            $apiVersion = $node->filter('h3')->extract(['id']);
            if (false === empty($apiVersion) && isset($apiVersion[0])) {
                return $apiVersion[0];
            }

            return null;
        });

        $apiVersions = \array_filter($apiChangelogValues);

        return \array_values($apiVersions);
    }

    private function getModelClasses(): array
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__ . '/../../src/Model');

        if (false === $finder->hasResults()) {
            throw new \RuntimeException('Impossible to find classes of models.');
        }

        $modelClasses = [];
        foreach ($finder as $file) {
            $fileName  = $file->getFilename();
            $fileName  = \str_replace('.' . $file->getExtension(), '', $fileName);
            $namespace = \Safe\sprintf('SerendipityHQ\Bundle\StripeBundle\Model\%s', $fileName);

            try {
                $reflectedClass = new \ReflectionClass($namespace);
            } catch (\ReflectionException $reflectionException) {
                throw new \RuntimeException(\Safe\sprintf("The guessed class \"%s\" doesn't exist.\nException message: %s", $namespace, $reflectionException->getMessage()));
            }

            if ($reflectedClass->isAbstract() || $reflectedClass->isInterface()) {
                continue;
            }

            $modelClasses[$fileName] = $namespace;
        }

        return $modelClasses;
    }

    private function guessSdkModelClassesFromLocalOnes(array $localModelClasses): array
    {
        $sdkModelClasses = [];
        foreach (\array_keys($localModelClasses) as $localModelName) {
            $sdkModelName      = \str_replace('StripeLocal', '', $localModelName);
            $sdkModelNamespace = \Safe\sprintf('Stripe\%s', $sdkModelName);

            if (false === \class_exists($sdkModelNamespace)) {
                throw new \RuntimeException(\Safe\sprintf('The guessed SDK class "%s" doesn\'t exist.', $sdkModelNamespace));
            }

            $sdkModelClasses[$localModelName] = $sdkModelNamespace;
        }

        return $sdkModelClasses;
    }

    private function testLocalModelIsInSynchWithSdkModel(string $localModelClass, string $sdkModelClass): array
    {
        $localModelProperties = $this->getLocalModelProperties($localModelClass);
        $sdkModelProperties   = $this->getSdkModelProperties($sdkModelClass);

        $localModelPropertiesThatDoNotExistAnymore = \array_diff($localModelProperties, $sdkModelProperties);
        $localModelPropertiesThatDoNotExistAnymore = \array_diff($localModelPropertiesThatDoNotExistAnymore, $localModelClass::IGNORE);

        $sdkModelPropertiesNotYetImplemented =  \array_diff($sdkModelProperties, $localModelProperties);
        $sdkModelPropertiesNotYetImplemented =  \array_diff($sdkModelPropertiesNotYetImplemented, $localModelClass::IGNORE_MODEL);

        $failures = [];
        if (false === empty($localModelPropertiesThatDoNotExistAnymore)) {
            $failures[] = \Safe\sprintf("%s contains fields not present in %s anymore:\n  - %s", $localModelClass, $sdkModelClass, \implode("\n  - ", $localModelPropertiesThatDoNotExistAnymore));
        }

        if (false === empty($sdkModelPropertiesNotYetImplemented)) {
            $failures[] = \Safe\sprintf("%s contains fields not yet managed by %s:\n  - %s", $sdkModelClass, $localModelClass, \implode("\n  - ", $sdkModelPropertiesNotYetImplemented));
        }

        return $failures;
    }

    /**
     * @return array<array-key, ReflectionProperty>
     */
    private function getLocalModelProperties(string $class): array
    {
        $properties = (new \ReflectionClass($class))->getProperties();

        return \array_map(static function ($reflectedProperty): string {
            return $reflectedProperty->getName();
        }, $properties);
    }

    /**
     * @return array<array-key,string>
     */
    private function getSdkModelProperties(string $class): array
    {
        $reflectedSdkModel  = new \ReflectionClass($class);
        $docComment         = $reflectedSdkModel->getDocComment();
        $explodedDocComment = \explode("\n", $docComment);

        $properties = [];
        foreach ($explodedDocComment as $docCommentLine) {
            if (false === \strpos($docCommentLine, '* @property')) {
                continue;
            }

            $match = [];
            \Safe\preg_match('/\$\w+/', $docCommentLine, $match);

            if (false === isset($match[0])) {
                throw new \RuntimeException(\Safe\sprintf('Impossible to extract the property name. The DocComment line is: "%s"', $docCommentLine));
            }

            $properties[] = \str_replace('$', '', $match[0]);
        }

        return \array_map(static function ($property): string {
            return (new ByteString($property))->camel();
        }, $properties);
    }
}
