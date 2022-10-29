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

use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Compound;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\String_;
use function Safe\sprintf;
use SerendipityHQ\Bundle\StripeBundle\Dev\Helper\MappingHelper;
use SerendipityHQ\Bundle\StripeBundle\Dev\Helper\ReflectionHelper;
use SerendipityHQ\Bundle\StripeBundle\Dev\Helper\StaticHelper;
use SerendipityHQ\Bundle\StripeBundle\SHQStripeBundle;
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
    private const MAPPING_NULLABLE = 'nullable';
    private const MAPPING_TYPE     = 'type';

    /** @var string */
    protected static $defaultName = 'stripe:dev:check';

    /** @var string */
    protected static $defaultDescription = 'Checks API compatibility between Stripe, this bundle and your Symfony app.';
    private int $return = 0;

    protected function configure(): void
    {
        $this->addOption('skip-api', null, InputOption::VALUE_NONE, 'Do not check the implemented API is the last one released by Stripe.')
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
            $ioWriter->error('The Symfony DomCrawler component is not installed and it is required to run this command.
Run "composer req symfony/domcrawler" to install it.');
            $this->return = 1;

            return;
        }

        if (false === \class_exists(HttpClient::class)) {
            $ioWriter->error("The Symfony HTTP client doesn't exist and it is required to run this command.\nRun \"composer req symfony/http-client\" to install it.");
            $this->return = 1;

            return;
        }

        static $client = null;
        if (null === $client) {
            $client = HttpClient::create();
        }

        $apiVersions            = $this->scrapeApiVersions($client, $ioWriter);
        $supportedApiVersionKey = \array_search(SHQStripeBundle::SUPPORTED_STRIPE_API, $apiVersions, true);

        if (false === $supportedApiVersionKey) {
            $ioWriter->error(sprintf("The supported API version %s seems not a valid one: it doesn't exist in Stripe documentation.", SHQStripeBundle::SUPPORTED_STRIPE_API));
            $this->return = 1;

            return;
        }

        $ioWriter->writeln(sprintf('Supported API Version: %s', SHQStripeBundle::SUPPORTED_STRIPE_API));
        $ioWriter->writeln(sprintf('Last API Version: %s', $apiVersions[0]));

        if (0 !== $supportedApiVersionKey) {
            $ioWriter->error(sprintf('The currently supported API version is %s versions behind the last released one.', $supportedApiVersionKey));
            $this->return = 1;

            return;
        }

        $ioWriter->success('The currently supported API version is even with the last released one.');
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
            $this->return = 1;

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
            $failures[] = sprintf("%s contains fields not present in %s anymore:\n  - %s", $localModelClass, $sdkModelClass, \implode("\n  - ", $localModelPropertiesThatDoNotExistAnymore));
        }

        if (false === empty($sdkModelPropertiesNotYetImplemented)) {
            $failures[] = sprintf("%s contains fields not yet managed by %s:\n  - %s", $sdkModelClass, $localModelClass, \implode("\n  - ", $sdkModelPropertiesNotYetImplemented));
        }

        $propertiesToCompare = \array_intersect($localModelProperties, $sdkModelProperties);
        $comparisonFailures  = $this->compareLocalPropertiesWithSdkOnes($localModelClass, $sdkModelClass, $propertiesToCompare);
        if (false === empty($comparisonFailures)) {
            $failures[] = sprintf("The types of properties of class %s doesn't match with the ones of %s class:\n  - %s", $localModelClass, $sdkModelClass, \implode("\n  - ", $comparisonFailures));
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
            $failures[] = sprintf("Mapping of %s contains fields not present in the model anymore:\n  - %s", $localModelClass, \implode("\n  - ", $mappedModelPropertiesThatDoNotExistAnymore));
        }

        if (false === empty($localModelPropertiesNotYetMapped)) {
            $failures[] = sprintf("%s contains properties not yet mapped:\n  - %s", $localModelClass, \implode("\n  - ", $localModelPropertiesNotYetMapped));
        }

        $propertiesToCompare = \array_intersect($localModelProperties, MappingHelper::getMappedProperties($localModelClass));
        $comparisonFailures  = $this->compareLocalPropertiesWithMappedOnes($localModelClass, $propertiesToCompare);
        if (false === empty($comparisonFailures)) {
            $failures[] = sprintf("The types of properties of class %s doesn't match with the mapped ones:\n  - %s", $localModelClass, \implode("\n  - ", $comparisonFailures));
        }

        // Remove null values eventually returned by compareLocalPropertiesWithSdkOnes()
        return \array_filter($failures);
    }

    /**
     * @return array<array-key,string>
     */
    private function scrapeApiVersions(HttpClientInterface $client, SymfonyStyle $ioWriter): array
    {
        $ioWriter->writeln('Calling https://stripe.com/docs/upgrades ...');

        $response = $client->request('GET', 'https://stripe.com/docs/upgrades');

        $statusCode = $response->getStatusCode();
        $ioWriter->writeln(sprintf('Status code returned: %s', $statusCode));

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

    private function compareLocalPropertiesWithSdkOnes(string $localModelClass, string $sdkModelClass, array $propertiesToCompare): array
    {
        $failures = [];
        foreach ($propertiesToCompare as $propertyToCompare) {
            $localPropertyDocBlock = ReflectionHelper::getLocalModelPropertyDocComment($localModelClass, $propertyToCompare);
            $sdkPropertyDocBlock   = ReflectionHelper::getSdkModelPropertyDocComment($sdkModelClass, $propertyToCompare);

            $localPropertyVar = $localPropertyDocBlock->getTagsByName('var');

            if (false === isset($localPropertyVar[0])) {
                throw new \RuntimeException('Something unexpected happened.');
            }

            $localPropertyVar = $localPropertyVar[0];

            if (false === $localPropertyVar instanceof Var_) {
                throw new \RuntimeException('Unexpected @var type.');
            }

            $localType  = $localPropertyVar->getType();
            $localTypes = is_countable($localType) ? $localType : [$localType];

            $sdkType  = $sdkPropertyDocBlock->getType();
            $sdkTypes = is_countable($sdkType) ? $sdkType : [$sdkType];

            try {
                $comparison = $this->compareTypes($localModelClass, $propertyToCompare, $localTypes, $sdkTypes);
            } catch (\OutOfBoundsException $outOfBoundsException) {
                throw new \OutOfBoundsException(sprintf('%s::$%s: %s', $localModelClass, $propertyToCompare, $outOfBoundsException->getMessage()));
            }

            if (false === empty($comparison)) {
                $failures[] = sprintf("%s:\n    - %s", $propertyToCompare, \implode("\n    - ", $comparison));
            }
        }

        return $failures;
    }

    private function compareLocalPropertiesWithMappedOnes(string $localModelClass, array $propertiesToCompare): array
    {
        $failures = [];
        foreach ($propertiesToCompare as $propertyToCompare) {
            $localPropertyDocBlock = ReflectionHelper::getLocalModelPropertyDocComment($localModelClass, $propertyToCompare);
            $mappedPropertyInfo    = MappingHelper::getMappedProperty($localModelClass, $propertyToCompare);

            // If it is null, it is an embeddable or the field doesn't exist.
            // If it doesn't exist, then there are other rules that report this error.
            if (null === $mappedPropertyInfo) {
                continue;
            }

            $localPropertyVar = $localPropertyDocBlock->getTagsByName('var');

            if (false === isset($localPropertyVar[0])) {
                throw new \RuntimeException('Something unexpected happened.');
            }

            $localPropertyVar = $localPropertyVar[0];

            if (false === $localPropertyVar instanceof Var_) {
                throw new \RuntimeException('Unexpected @var type.');
            }

            $processTypes = static function ($type): string {
                if ($type instanceof Type) {
                    $type = \get_class($type);
                }

                $type = \str_replace(['_', 'phpDocumentor\Reflection\Types', '\\'], '', $type);

                return \strtolower($type);
            };

            $processMappings = static function (array $mapping): array {
                $types = [];

                if (isset($mapping[self::MAPPING_TYPE])) {
                    switch ($mapping[self::MAPPING_TYPE]) {
                        case 'text':
                        case 'uri':
                            $types[] = 'string';

                            break;
                        default:
                            $types[] = $mapping[self::MAPPING_TYPE];
                    }
                }

                if (isset($mapping[self::MAPPING_NULLABLE]) && $mapping[self::MAPPING_NULLABLE]) {
                    $types[] = 'null';
                }

                return $types;
            };

            $localType  = $localPropertyVar->getType();
            $localTypes = is_countable($localType) ? $localType : [$localType];
            $localTypes = $this->extractTypes($localTypes);
            $localTypes = $this->convertTypes($localTypes);
            $localTypes = \array_map($processTypes, $localTypes);

            $mappedTypes = $processMappings($mappedPropertyInfo);

            $comparison = \array_filter(\array_diff($localTypes, $mappedTypes));

            if (false === empty($comparison)) {
                $failures[] = sprintf("%s:\n    - %s", $propertyToCompare, \implode("\n    - ", $comparison));
            }
        }

        return $failures;
    }

    /**
     * @param array<array-key, Type>|Type $localTypes
     * @param array<array-key, Type>|Type $sdkTypes
     */
    private function compareTypes(string $localModelClass, string $property, array $localTypes, array $sdkTypes): array
    {
        $localTypes = $this->extractTypes($localTypes);
        $sdkTypes   = $this->extractTypes($sdkTypes);

        $localTypesClasses = $this->convertTypes($localTypes);
        $sdkTypesClasses   = $this->convertTypes($sdkTypes);

        // Remove null values returned by the callback
        $localTypesClasses = \array_filter($localTypesClasses);
        $sdkTypesClasses   = \array_filter($sdkTypesClasses);

        $localTypesClasses = StaticHelper::filterTypes($localModelClass, $property, $localTypesClasses);
        $sdkTypesClasses   = StaticHelper::filterTypes($localModelClass, $property, $sdkTypesClasses);

        return \array_merge(\array_diff($localTypesClasses, $sdkTypesClasses), \array_diff($sdkTypesClasses, $localTypesClasses));
    }

    /**
     * @param array<array-key, Type>|Type $types
     */
    private function extractTypes($types): array
    {
        if ($types instanceof Compound) {
            $types = $types->getIterator()->getArrayCopy();
        }

        if (false === \is_iterable($types)) {
            $types = [$types];
        }

        return $types;
    }

    private function convertTypes(array $types): array
    {
        $callback = static function ($type): ?string {
            if ($type instanceof Object_) {
                switch ($type->getFqsen()->getName()) {
                    case 'Collection':
                    case 'StripeObject':
                    case 'AddressInterface':
                        return Array_::class;
                    case 'PhoneInterface':
                    case 'UriInterface':
                        return String_::class;
                    default:
                        throw new \OutOfBoundsException(sprintf('%s is not supported by the CheckCommand::convertTypes() method. Please, implement it to fix this exception.', $type->getFqsen()->getName()));
                }
            }

            return \get_class($type);
        };

        return \array_map($callback, $types);
    }
}
