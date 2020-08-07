<?php

declare(strict_types = 1);

/*
 * This file is part of the Serendipity HQ Aws Ses Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\SetList;

return static function (ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PHP_VERSION_FEATURES, '7.2');

    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/tests'
    ]);

    $parameters->set(Option::AUTOLOAD_PATHS, [__DIR__ . '/vendor-bin/phpunit/vendor/autoload.php']);

    $parameters->set(
        Option::SETS,
        [
            SetList::ACTION_INJECTION_TO_CONSTRUCTOR_INJECTION,
            SetList::ARRAY_STR_FUNCTIONS_TO_STATIC_CALL,
            SetList::CONSTRUCTOR_INJECTIN_TO_ACTION_INJECTION,
            SetList::CODE_QUALITY,
            SetList::CODING_STYLE,
            SetList::MONOLOG_20,
            SetList::PHP_DI_DECOUPLE,
            SetList::SWIFTMAILER_60,
            SetList::DOCTRINE_25,
            SetList::DOCTRINE_CODE_QUALITY,
            SetList::DOCTRINE_SERVICES,
            SetList::DOCTRINE_DBAL_210,
            SetList::FRAMEWORK_EXTRA_BUNDLE_40,
            SetList::FRAMEWORK_EXTRA_BUNDLE_50,
            SetList::GUZZLE_50,
            SetList::PERFORMANCE,
            SetList::PHP_52,
            SetList::PHP_53,
            SetList::PHP_54,
            SetList::PHP_56,
            SetList::PHP_70,
            SetList::PHP_71,
            SetList::PHP_72,
            SetList::PHPSTAN,
            SetList::PHPUNIT_40,
            SetList::PHPUNIT_50,
            SetList::PHPUNIT_60,
            SetList::PHPUNIT_70,
            SetList::PHPUNIT_75,
            SetList::PHPUNIT_80,
            SetList::PHPUNIT80_DMS,
            SetList::PHPUNIT_CODE_QUALITY,
            SetList::PHPUNIT_EXCEPTION,
            SetList::PHPUNIT_INJECTOR,
            SetList::PHPUNIT_MOCK,
            SetList::PHPUNIT_SPECIFIC_METHOD,
            SetList::PHPUNIT_YIELD_DATA_PROVIDER,
            SetList::UNWRAP_COMPAT,
            SetList::SOLID,
            SetList::SYMFONY_26,
            SetList::SYMFONY_28,
            SetList::SYMFONY_30,
            SetList::SYMFONY_31,
            SetList::SYMFONY_32,
            SetList::SYMFONY_33,
            SetList::SYMFONY_34,
            SetList::SYMFONY_40,
            SetList::SYMFONY_41,
            SetList::SYMFONY_42,
            SetList::SYMFONY_43,
            SetList::SYMFONY_44,
            SetList::SYMFONY_50,
            SetList::SYMFONY_50_TYPES,
            SetList::SYMFONY_CODE_QUALITY,
            SetList::SYMFONY_CONSTRUCTOR_INJECTION,
            SetList::SYMFONY_PHPUNIT,
            SetList::SAFE_07,
            SetList::TYPE_DECLARATION,
            SetList::TWIG_112,
            SetList::TWIG_127,
            SetList::TWIG_134,
            SetList::TWIG_140,
            SetList::TWIG_20,
            SetList::TWIG_240,
            SetList::TWIG_UNDERSCORE_TO_NAMESPACE,
        ]
    );

    $parameters->set(
        Option::EXCLUDE_RECTORS,
        [
            Rector\CodeQuality\Rector\Catch_\ThrowWithPreviousExceptionRector::class,
            Rector\CodeQuality\Rector\Concat\JoinStringConcatRector::class,
            Rector\CodeQuality\Rector\Identical\SimplifyBoolIdenticalTrueRector::class,
            Rector\CodingStyle\Rector\Class_\AddArrayDefaultToArrayPropertyRector::class,
            Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector::class,
            Rector\CodingStyle\Rector\ClassMethod\RemoveDoubleUnderscoreInMethodNameRector::class,
            Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector::class,
            Rector\CodingStyle\Rector\Identical\IdenticalFalseToBooleanNotRector::class,
            Rector\CodingStyle\Rector\Switch_\BinarySwitchToIfElseRector::class,
            Rector\CodingStyle\Rector\Throw_\AnnotateThrowablesRector::class,
            Rector\CodingStyle\Rector\Use_\RemoveUnusedAliasRector::class,
            Rector\Php56\Rector\FunctionLike\AddDefaultValueForUndefinedVariableRector::class, // Maybe good one day
            Rector\PHPUnit\Rector\Class_\AddSeeTestAnnotationRector::class,
            Rector\PHPUnit\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector::class,
            Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector::class,
            Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector::class,
            Rector\SOLID\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector::class,
            Rector\SOLID\Rector\Property\AddFalseDefaultToBoolPropertyRector::class,
            Rector\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector::class,
            Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector::class,
        ]
    );
};
