<?php

declare(strict_types = 1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Set\ValueObject\SetList;

return static function (ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_74);

    $parameters->set(Option::PATHS, [
        __DIR__ . '/dev',
        __DIR__ . '/src',
        // This causes issues with controllers
        // Until required for tests, keep it commented
        // __DIR__ . '/tests'
    ]);

    // This causes issues with controllers
    // Until required for tests, keep it commented
    //$parameters->set(Option::BOOTSTRAP_FILES, [__DIR__ . '/vendor-bin/phpunit/vendor/autoload.php']);

    $containerConfigurator->import(SetList::ACTION_INJECTION_TO_CONSTRUCTOR_INJECTION);
    $containerConfigurator->import(SetList::CODE_QUALITY);
    $containerConfigurator->import(SetList::CODING_STYLE);
    $containerConfigurator->import(SetList::MONOLOG_20);
    $containerConfigurator->import(SetList::FRAMEWORK_EXTRA_BUNDLE_40);
    $containerConfigurator->import(SetList::FRAMEWORK_EXTRA_BUNDLE_50);
    $containerConfigurator->import(SetList::PHP_52);
    $containerConfigurator->import(SetList::PHP_53);
    $containerConfigurator->import(SetList::PHP_54);
    $containerConfigurator->import(SetList::PHP_56);
    $containerConfigurator->import(SetList::PHP_70);
    $containerConfigurator->import(SetList::PHP_71);
    $containerConfigurator->import(SetList::PHP_72);
    $containerConfigurator->import(SetList::PHP_73);
    $containerConfigurator->import(SetList::UNWRAP_COMPAT);
    $containerConfigurator->import(SetList::SAFE_07);
    $containerConfigurator->import(SetList::TYPE_DECLARATION);

    $parameters->set(
        Option::SKIP,
        [
            /*
            __DIR__ . '/dev/Command/CheckCommand.php',
            __DIR__ . '/dev/Doctrine/MappingFilesLocator.php',
            __DIR__ . '/dev/Helper/MappingHelper.php',
            __DIR__ . '/dev/Helper/ReflectionHelper.php',
            __DIR__ . '/dev/Helper/StaticHelper.php',
            __DIR__ . '/src/Controller/WebhookController.php',
            __DIR__ . '/src/DependencyInjection/SHQStripeExtension.php',
            __DIR__ . '/src/Event/AbstractStripeChargeEvent.php',
            __DIR__ . '/src/Event/AbstractStripeCustomerEvent.php',
            __DIR__ . '/src/Event/AbstractStripeEvent.php',
            __DIR__ . '/src/Event/AbstractStripeWebhookEventEvent.php',
            __DIR__ . '/src/Form/Type/CreditCardStripeTokenType.php',
            __DIR__ . '/src/Manager/StripeManager.php',
            __DIR__ . '/src/Model/*',
            __DIR__ . '/src/Repository/*',
            __DIR__ . '/src/SHQStripeBundle.php',
            __DIR__ . '/src/Subscriber/*',
            __DIR__ . '/src/Syncer/*',
            __DIR__ . '/src/Util/EventGuesser.php',
            __DIR__ . '/tests/DependencyInjection/*',
            __DIR__ . '/tests/Form/Type/CreditCardStripeTokenTypeTest.php',
            __DIR__ . '/tests/Model/StripeLocalChargeTest.php',
            __DIR__ . '/tests/Model/StripeLocalCustomerTest.php',
            __DIR__ . '/tests/Model/StripeLocalWebhookEventTest.php',
            */
            Rector\CodeQuality\Rector\Catch_\ThrowWithPreviousExceptionRector::class,
            Rector\CodeQuality\Rector\Concat\JoinStringConcatRector::class,
            Rector\CodeQuality\Rector\Identical\SimplifyBoolIdenticalTrueRector::class,
            Rector\CodingStyle\Rector\Class_\AddArrayDefaultToArrayPropertyRector::class,
            Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector::class,
            Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector::class,
            Rector\CodingStyle\Rector\ClassMethod\RemoveDoubleUnderscoreInMethodNameRector::class,
            Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector::class,
            Rector\CodingStyle\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector::class,
            Rector\CodingStyle\Rector\Switch_\BinarySwitchToIfElseRector::class,
            Rector\CodingStyle\Rector\Use_\RemoveUnusedAliasRector::class,
            Rector\Php56\Rector\FunctionLike\AddDefaultValueForUndefinedVariableRector::class, // Maybe good one day
            Rector\PHPUnit\Rector\Class_\AddSeeTestAnnotationRector::class,
            Rector\PHPUnit\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector::class,
            Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector::class,
            Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector::class,
            Rector\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector::class,
            Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector::class,
            Rector\Php70\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector::class,
            Rector\Arguments\Rector\ClassMethod\ArgumentAdderRector::class, // BUGGED: Adds an int but is expected a string
            \Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector::class,
            \Rector\CodeQuality\Rector\Identical\FlipTypeControlToUseExclusiveTypeRector::class,
            \Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector::class // BUGGED: https://github.com/rectorphp/rector/issues/6852
        ]
    );
};
