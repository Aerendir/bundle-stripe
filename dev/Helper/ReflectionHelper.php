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

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Tags\Property;
use phpDocumentor\Reflection\DocBlockFactory;
use Symfony\Component\Finder\Finder;
use Symfony\Component\String\ByteString;

class ReflectionHelper
{
    /** @var DocBlockFactory|null */
    private static $docBlockFactory = null;

    /** @var array<string, array<string, DocBlock>> */
    private static $localModelsCache = [];

    /** @var array<string, array<string,\phpDocumentor\Reflection\DocBlock\Tags\Property>> */
    private static $sdkModelsCache = [];

    /**
     * @return array<array-key, ReflectionProperty>
     */
    public static function getLocalModelPropertiesDocComments(string $localModelClass): array
    {
        if (false === isset(self::$localModelsCache[$localModelClass])) {
            $properties = (new \ReflectionClass($localModelClass))->getProperties();

            foreach ($properties as $property) {
                self::$localModelsCache[$localModelClass][$property->getName()] = self::getDockBlockFactory()->create($property->getDocComment());
            }
        }

        return self::$localModelsCache[$localModelClass];
    }

    public static function getLocalModelPropertyDocComment(string $localModelClass, string $property): DocBlock
    {
        if (false === isset(self::$localModelsCache[$localModelClass][$property])) {
            self::getLocalModelPropertiesDocComments($localModelClass);
        }

        return self::$localModelsCache[$localModelClass][$property];
    }

    /**
     * @return array<array-key, string>
     */
    public static function getLocalModelProperties(string $localModelClass): array
    {
        $reflectedProperties = self::getLocalModelPropertiesDocComments($localModelClass);

        return \array_keys($reflectedProperties);
    }

    /**
     * @return array<array-key, ReflectionProperty>
     */
    public static function getSdkModelPropertiesDocComments(string $sdkModelClass): array
    {
        if (false === isset(self::$sdkModelsCache[$sdkModelClass])) {
            $reflectedSdkModel = new \ReflectionClass($sdkModelClass);
            $docComment        = self::getDockBlockFactory()->create($reflectedSdkModel->getDocComment());

            foreach ($docComment->getTagsByName('property') as $docCommentLine) {
                if ( ! $docCommentLine instanceof Property) {
                    continue;
                }

                $propertyName                                        = (new ByteString($docCommentLine->getVariableName()))->camel()->toString();
                self::$sdkModelsCache[$sdkModelClass][$propertyName] = $docCommentLine;
            }
        }

        return self::$sdkModelsCache[$sdkModelClass];
    }

    public static function getSdkModelPropertyDocComment(string $sdkModelClass, string $property): Property
    {
        if (false === isset(self::$sdkModelsCache[$sdkModelClass][$property])) {
            self::getSdkModelPropertiesDocComments($sdkModelClass);
        }

        return self::$sdkModelsCache[$sdkModelClass][$property];
    }

    /**
     * @return array<array-key,string>
     */
    public static function getSdkModelProperties(string $sdkModelClass): array
    {
        $properties = self::getSdkModelPropertiesDocComments($sdkModelClass);

        return \array_keys($properties);
    }

    public static function getModelClasses(): array
    {
        static $modelClasses = null;

        if (\is_array($modelClasses)) {
            return $modelClasses;
        }

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

    public static function guessSdkModelClassesFromLocalOnes(array $localModelClasses): array
    {
        static $sdkModelClasses = null;

        if (\is_array($sdkModelClasses)) {
            return $sdkModelClasses;
        }

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

    private static function getDockBlockFactory(): DocBlockFactory
    {
        if (null === self::$docBlockFactory) {
            self::$docBlockFactory = DocBlockFactory::createInstance();
        }

        return self::$docBlockFactory;
    }
}
