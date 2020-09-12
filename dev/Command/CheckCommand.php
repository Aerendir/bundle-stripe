<?php

declare(strict_types=1);

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Dev\Command;

use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Compound;
use phpDocumentor\Reflection\Types\String_;
use SerendipityHQ\Bundle\StripeBundle\Dev\Helper\MappingHelper;
use SerendipityHQ\Bundle\StripeBundle\Dev\Helper\ReflectionHelper;
use SerendipityHQ\Bundle\StripeBundle\Dev\Helper\StaticHelper;
use SerendipityHQ\Bundle\StripeBundle\SHQStripeBundle;
use SerendipityHQ\Component\ValueObjects\Phone\PhoneInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class CheckCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'stripe:dev:check';

    /** @var int $return */
    private $return = self::SUCCESS;

    protected function configure(): void
    {
        $this
            ->setDescription('Checks API compatibility between Stripe, this bundle and your Symfony app.')
            ->addOption('skip-api', null, InputOption::VALUE_NONE, 'Do not check the implemented API is the last one released by Stripe.')
            ->addOption('skip-models', null, InputOption::VALUE_NONE, 'Do not check local and SDK models are in sync.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $ioWriter = new SymfonyStyle($input, $output);
        $ioWriter->title('Starting ' . self::$defaultName);

        (bool) $input->getOption('skip-api')
            ? $ioWriter->writeln('Skipping checking of API...')
            : $this->checkApiVersion($ioWriter);

        (bool) $input->getOption('skip-models')
            ? $ioWriter->writeln('Skipping checking of models...')
            : $this->checkLocalModels($ioWriter);

        return $this->return;
    }

    private function checkApiVersion(SymfonyStyle $ioWriter): void
    {
        if (false === \class_exists(Crawler::class)) {
            $ioWriter->error(\Safe\sprintf('The Symfony DomCrawler component is not installed and it is required to run this command.
Run "composer req symfony/domcrawler" to install it.'));
            $this->return = self::FAILURE;

            return;
        }

        if (false === \class_exists(HttpClient::class)) {
            $ioWriter->error(\Safe\sprintf("The Symfony HTTP client doesn't exist and it is required to run this command.\nRun \"composer req symfony/http-client\" to install it."));
            $this->return = self::FAILURE;

            return;
        }

        static $client = null;
        if (null === $client) {
            $client = HttpClient::create();
        }

        $apiVersions            = $this->scrapeApiVersions($client, $ioWriter);
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

    private function checkLocalModels(SymfonyStyle $ioWriter): void
    {
        $localModelClasses = ReflectionHelper::getModelClasses();

        // This is not an SDK model classes, but it is used internally to manage Stripe's webhook
        unset($localModelClasses['StripeLocalWebhookEvent']);

        $sdkModelClasses = ReflectionHelper::guessSdkModelClassesFromLocalOnes($localModelClasses);

        $failures = [];
        foreach ($localModelClasses as $localModelName => $localModelClass) {
            $failures[] = $this->checkLocalModelIsInSyncWithSdkModel($localModelClass, $sdkModelClasses[$localModelName]);
            $failures[] = $this->checkLocalModelIsInSyncWithMapping($localModelClass);
        }

        $failures = \array_merge(...$failures);
        if ( ! empty($failures)) {
            $ioWriter->error(\implode("\n", $failures));
            $this->return = self::FAILURE;

            return;
        }

        $ioWriter->success('Local model classes and SDK model classes are all in sync.');
    }

    private function checkLocalModelIsInSyncWithSdkModel(string $localModelClass, string $sdkModelClass): array
    {
        $localModelProperties = ReflectionHelper::getLocalModelProperties($localModelClass);
        $sdkModelProperties   = ReflectionHelper::getSdkModelProperties($sdkModelClass);

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

        $propertiesToCheck  = \array_intersect($localModelProperties, $sdkModelProperties);
        $comparisonFailures = $this->compareLocalPropertiesWithSdkOnes($localModelClass, $sdkModelClass, $propertiesToCheck);
        if (false === empty($comparisonFailures)) {
            $failures[] = \Safe\sprintf("The types of properties of class %s doesn't match with the ones of %s class:\n  - %s", $localModelClass, $sdkModelClass, \implode("\n  - ", $comparisonFailures));
        }

        // Remove null values eventually returned by compareLocalPropertiesWithSdkOnes()
        return \array_filter($failures);
    }

    private function checkLocalModelIsInSyncWithMapping(string $localModelClass): array
    {
        $localModelProperties  = ReflectionHelper::getLocalModelProperties($localModelClass);
        $mappedModelProperties = \array_merge(
            MappingHelper::getMappedProperties($localModelClass),
            MappingHelper::getMappedAssociations($localModelClass),
            $localModelClass::IGNORE,
        );
        $mappedModelProperties = \array_unique($mappedModelProperties);

        $mappedModelPropertiesThatDoNotExistAnymore = \array_diff($mappedModelProperties, $localModelProperties);
        $localModelPropertiesNotYetMapped           =  \array_diff($localModelProperties, $mappedModelProperties);

        $failures = [];

        if (false === empty($mappedModelPropertiesThatDoNotExistAnymore)) {
            $failures[] = \Safe\sprintf("Mapping of %s contains fields not present in the model anymore:\n  - %s", $localModelClass, \implode("\n  - ", $mappedModelPropertiesThatDoNotExistAnymore));
        }

        if (false === empty($localModelPropertiesNotYetMapped)) {
            $failures[] = \Safe\sprintf("%s contains properties not yet mapped:\n  - %s", $localModelClass, \implode("\n  - ", $localModelPropertiesNotYetMapped));
        }

        return $failures;
    }

    /**
     * @return array<array-key,string>
     */
    private function scrapeApiVersions(HttpClientInterface $client, SymfonyStyle $ioWriter): array
    {
        $ioWriter->writeln('Calling https://stripe.com/docs/upgrades ...');

        $response = $client->request('GET', 'https://stripe.com/docs/upgrades');

        $statusCode = $response->getStatusCode();
        $ioWriter->writeln(\Safe\sprintf('Status code returned: %s', $statusCode));

        $html = $response->getContent();

        $crawler            = new Crawler($html);
        $apiChangelogNode   = $crawler->filter('h2#api-changelog');
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

    private function compareLocalPropertiesWithSdkOnes(string $localModelClass, string $sdkModelClass, array $localProperties): array
    {
        $failures = [];
        foreach ($localProperties as $localProperty) {
            $localPropertyDocBlock = ReflectionHelper::getLocalModelPropertyDocComment($localModelClass, $localProperty);
            $sdkPropertyDocBlock   = ReflectionHelper::getSdkModelPropertyDocComment($sdkModelClass, $localProperty);

            $localPropertyVar = $localPropertyDocBlock->getTagsByName('var');

            if (false === isset($localPropertyVar[0])) {
                throw new \RuntimeException('Something unexpected happened.');
            }

            $localPropertyVar = $localPropertyVar[0];

            if (false === $localPropertyVar instanceof \phpDocumentor\Reflection\DocBlock\Tags\Var_) {
                throw new \RuntimeException('Unexpected @var type.');
            }

            $comparison = $this->compareTypes($localModelClass, $localProperty, $localPropertyVar->getType(), $sdkPropertyDocBlock->getType());

            if ($localProperty === 'address') {
                //dd($localPropertyVar, $sdkPropertyDocBlock);
            }

            if (false === empty($comparison)) {
                $failures[] = \Safe\sprintf("%s:\n    - %s", $localProperty, \implode("\n    - ", $comparison));
            }
        }

        return $failures;
    }

    /**
     * @param string $localModelClass
     * @param string $property
     * @param Type|array<array-key, Type> $localTypes
     * @param Type|array<array-key, Type> $sdkTypes
     */
    private function compareTypes(string $localModelClass, string $property, $localTypes, $sdkTypes): array
    {
        $callback = static function ($type): ?string {
            if ($type instanceof \phpDocumentor\Reflection\Types\Object_) {
                switch ($type->getFqsen()->getName()) {
                    case 'Collection':
                    case 'StripeObject':
                    case 'AddressInterface':
                        return Array_::class;
                    case 'PhoneInterface':
                    case 'UriInterface':
                        return String_::class;
                    default:
                        return null;
                }
            }

            return \get_class($type);
        };

        if ($localTypes instanceof Compound) {
            $localTypes = $localTypes->getIterator()->getArrayCopy();
        }

        if ($sdkTypes instanceof Compound) {
            $sdkTypes = $sdkTypes->getIterator()->getArrayCopy();
        }

        if (false === \is_iterable($localTypes)) {
            $localTypes = [$localTypes];
        }

        if (false === \is_iterable($sdkTypes)) {
            $sdkTypes = [$sdkTypes];
        }

        $localTypesClasses = \array_map($callback, $localTypes);
        $sdkTypesClasses   = \array_map($callback, $sdkTypes);

        // Remove null values returned by the callback
        $localTypesClasses = \array_filter($localTypesClasses);
        $sdkTypesClasses   = \array_filter($sdkTypesClasses);

        $localTypesClasses = StaticHelper::filterTypes($localModelClass, $property, $localTypesClasses);
        $sdkTypesClasses = StaticHelper::filterTypes($localModelClass, $property, $sdkTypesClasses);

        return array_merge(\array_diff($localTypesClasses, $sdkTypesClasses), \array_diff($sdkTypesClasses, $localTypesClasses));
    }
}
