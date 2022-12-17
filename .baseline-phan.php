<?php
/**
 * This is an automatically generated baseline for Phan issues.
 * When Phan is invoked with --load-baseline=path/to/baseline.php,
 * The pre-existing issues listed in this file won't be emitted.
 *
 * This file can be updated by invoking Phan with --save-baseline=path/to/baseline.php
 * (can be combined with --load-baseline)
 */
return [
    // # Issue statistics:
    // PhanUndeclaredStaticMethod : 85+ occurrences
    // PhanRedefinedClassReference : 80+ occurrences
    // PhanUnreferencedPublicClassConstant : 70+ occurrences
    // PhanUnreferencedPublicMethod : 60+ occurrences
    // PhanReadOnlyPrivateProperty : 30+ occurrences
    // PhanDeprecatedFunction : 25+ occurrences
    // PhanUndeclaredMethod : 25+ occurrences
    // PhanUnreferencedClass : 10+ occurrences
    // PhanTypeArraySuspiciousNullable : 7 occurrences
    // PhanTypeMismatchArgumentNullable : 7 occurrences
    // PhanUnextractableAnnotationSuffix : 7 occurrences
    // PhanRedefinedExtendedClass : 6 occurrences
    // PhanUnusedPublicMethodParameter : 4 occurrences
    // PhanTypeMismatchDeclaredReturn : 3 occurrences
    // PhanUnextractableAnnotationElementName : 3 occurrences
    // PhanUnusedPublicFinalMethodParameter : 3 occurrences
    // PhanParamSignatureMismatch : 2 occurrences
    // PhanParamTooFewInternalUnpack : 1 occurrence
    // PhanPossiblyInfiniteRecursionSameParams : 1 occurrence
    // PhanTypeExpectedObjectPropAccess : 1 occurrence
    // PhanTypeMismatchPropertyProbablyReal : 1 occurrence
    // PhanTypeMismatchReturnSuperType : 1 occurrence
    // PhanUndeclaredExtendedClass : 1 occurrence
    // PhanUndeclaredProperty : 1 occurrence
    // PhanUnreferencedProtectedMethod : 1 occurrence
    // PhanWriteOnlyPublicProperty : 1 occurrence

    // Currently, file_suppressions and directory_suppressions are the only supported suppressions
    'file_suppressions' => [
        'dev/Command/CheckCommand.php' => ['PhanDeprecatedFunction', 'PhanParamTooFewInternalUnpack', 'PhanRedefinedClassReference', 'PhanRedefinedExtendedClass', 'PhanUnextractableAnnotationElementName', 'PhanUnextractableAnnotationSuffix'],
        'dev/Doctrine/MappingFilesLocator.php' => ['PhanDeprecatedFunction', 'PhanParamSignatureMismatch', 'PhanUnusedPublicMethodParameter'],
        'dev/Helper/ReflectionHelper.php' => ['PhanDeprecatedFunction', 'PhanRedefinedClassReference', 'PhanTypeMismatchArgumentNullable', 'PhanUnextractableAnnotationSuffix', 'PhanUnreferencedPublicMethod'],
        'dev/Helper/StaticHelper.php' => ['PhanRedefinedClassReference'],
        'src/Controller/WebhookController.php' => ['PhanDeprecatedFunction', 'PhanUndeclaredMethod', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'src/DependencyInjection/SHQStripeExtension.php' => ['PhanDeprecatedFunction'],
        'src/Event/AbstractStripeEvent.php' => ['PhanUnreferencedPublicMethod'],
        'src/Event/StripeCustomerUpdateEvent.php' => ['PhanUnreferencedPublicMethod'],
        'src/Event/StripeWebhookAccountEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookApplicationFeeEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookBalanceEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookBitcoinEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookChargeEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookCouponEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookCustomerEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookInvoiceEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookInvoiceItemEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookOrderEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookOrderReturnEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookPingEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookProductEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookRecipientEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookReviewEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookSkuEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookSourceEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookTransferEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Form/Type/CreditCardStripeTokenType.php' => ['PhanUnusedPublicFinalMethodParameter'],
        'src/Manager/StripeManager.php' => ['PhanDeprecatedFunction', 'PhanPossiblyInfiniteRecursionSameParams', 'PhanRedefinedClassReference', 'PhanTypeArraySuspiciousNullable', 'PhanTypeMismatchArgumentNullable', 'PhanUnreferencedPublicMethod', 'PhanWriteOnlyPublicProperty'],
        'src/Model/StripeLocalCard.php' => ['PhanReadOnlyPrivateProperty', 'PhanUnreferencedPublicClassConstant', 'PhanUnreferencedPublicMethod', 'PhanUnusedPublicMethodParameter'],
        'src/Model/StripeLocalCharge.php' => ['PhanReadOnlyPrivateProperty', 'PhanTypeMismatchReturnSuperType', 'PhanUnreferencedPublicClassConstant', 'PhanUnreferencedPublicMethod'],
        'src/Model/StripeLocalCustomer.php' => ['PhanDeprecatedFunction', 'PhanReadOnlyPrivateProperty', 'PhanTypeMismatchArgumentNullable', 'PhanTypeMismatchDeclaredReturn', 'PhanUnreferencedPublicClassConstant', 'PhanUnreferencedPublicMethod'],
        'src/Model/StripeLocalWebhookEvent.php' => ['PhanReadOnlyPrivateProperty', 'PhanTypeMismatchDeclaredReturn', 'PhanUnusedPublicMethodParameter'],
        'src/Subscriber/StripeChargeSubscriber.php' => ['PhanTypeMismatchArgumentNullable', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'src/Subscriber/StripeCustomerSubscriber.php' => ['PhanTypeMismatchArgumentNullable', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'src/Syncer/AbstractSyncer.php' => ['PhanTypeMismatchDeclaredReturn'],
        'src/Syncer/CustomerSyncer.php' => ['PhanTypeExpectedObjectPropAccess', 'PhanTypeMismatchPropertyProbablyReal'],
        'src/Syncer/WebhookEventSyncer.php' => ['PhanUnusedPublicFinalMethodParameter'],
        'src/Util/EventGuesser.php' => ['PhanDeprecatedFunction'],
        'tests/DependencyInjection/AbstractStripeBundleExtensionTest.php' => ['PhanRedefinedExtendedClass', 'PhanTypeArraySuspiciousNullable', 'PhanUndeclaredStaticMethod', 'PhanUnreferencedProtectedMethod', 'PhanUnreferencedPublicMethod'],
        'tests/DependencyInjection/YamlStripeBundleExtensionTest.php' => ['PhanUndeclaredMethod', 'PhanUnreferencedClass'],
        'tests/Event/AbstractStripeChargeEventTest.php' => ['PhanRedefinedExtendedClass', 'PhanUndeclaredMethod', 'PhanUndeclaredStaticMethod', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'tests/Event/AbstractStripeCustomerEventTest.php' => ['PhanRedefinedExtendedClass', 'PhanUndeclaredMethod', 'PhanUndeclaredStaticMethod', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'tests/Event/AbstractStripeWebhookEventEventTest.php' => ['PhanRedefinedExtendedClass', 'PhanUndeclaredMethod', 'PhanUndeclaredStaticMethod', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'tests/Form/Type/CreditCardStripeTokenTypeTest.php' => ['PhanUndeclaredExtendedClass', 'PhanUndeclaredProperty', 'PhanUndeclaredStaticMethod', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalCardTest.php' => ['PhanUndeclaredMethod', 'PhanUndeclaredStaticMethod', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalChargeTest.php' => ['PhanUndeclaredMethod', 'PhanUndeclaredStaticMethod', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalCustomerTest.php' => ['PhanUndeclaredMethod', 'PhanUndeclaredStaticMethod', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalWebhookEventTest.php' => ['PhanUndeclaredMethod', 'PhanUndeclaredStaticMethod', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'tests/ModelTestCase.php' => ['PhanRedefinedExtendedClass'],
    ],
    // 'directory_suppressions' => ['src/directory_name' => ['PhanIssueName1', 'PhanIssueName2']] can be manually added if needed.
    // (directory_suppressions will currently be ignored by subsequent calls to --save-baseline, but may be preserved in future Phan releases)
];
