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

namespace SerendipityHQ\Bundle\StripeBundle\Dev\Helper;

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Doctrine\ORM\Mapping\MappingException;
use SerendipityHQ\Bundle\StripeBundle\Dev\Doctrine\MappingFilesLocator;

class MappingHelper
{
    /** @var XmlDriver|null */
    private static $driver;
    /** @var mixed[] */
    private static $cache = [];

    public static function getMappedProperty(string $localModelClass, string $property): ?array
    {
        try {
            return self::getMetadataInfo($localModelClass)->getFieldMapping($property);
        } catch (MappingException $mappingException) {
        }

        return null;
    }

    public static function getMappedProperties(string $localModelClass): array
    {
        $metadataInfo = self::getMetadataInfo($localModelClass);
        $fieldNames   = $metadataInfo->getFieldNames();

        $reflectedMetadataInfo            = new \ReflectionClass($metadataInfo);
        $embeddedClassesReflectedProperty = $reflectedMetadataInfo->getProperty('embeddedClasses');
        $embeddedClassesReflectedProperty->setAccessible(true);
        $embeddables = \array_keys($metadataInfo->embeddedClasses);

        return \array_merge($fieldNames, $embeddables);
    }

    public static function getMappedAssociations(string $localModelClass): array
    {
        $metadataInfo = self::getMetadataInfo($localModelClass);

        return $metadataInfo->getAssociationNames();
    }

    private static function getMetadataInfo($localModelClass): ClassMetadataInfo
    {
        if (false === isset(self::$cache[$localModelClass])) {
            $metadataInfo = new ClassMetadataInfo($localModelClass);
            self::getDriver()->loadMetadataForClass($localModelClass, $metadataInfo);
            self::$cache[$localModelClass] = $metadataInfo;
        }

        return self::$cache[$localModelClass];
    }

    private static function getDriver(): XmlDriver
    {
        if (null === self::$driver) {
            $locator       = new MappingFilesLocator(__DIR__ . '/../../src/Resources/config/doctrine/mappings/', '.orm.xml');
            self::$driver  = new XmlDriver($locator, '.orm.xml');
        }

        return self::$driver;
    }
}
