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
    // PhanRedefinedClassReference : 150+ occurrences
    // PhanUnreferencedPublicClassConstant : 70+ occurrences
    // PhanUnreferencedPublicMethod : 60+ occurrences
    // PhanReadOnlyPrivateProperty : 30+ occurrences
    // PhanTypeMismatchArgument : 10+ occurrences
    // PhanTypeMismatchDeclaredReturn : 10+ occurrences
    // PhanTypeMismatchArgumentNullable : 8 occurrences
    // PhanUndeclaredMethod : 8 occurrences
    // PhanUnextractableAnnotationSuffix : 7 occurrences
    // PhanTypeArraySuspiciousNullable : 6 occurrences
    // PhanRedefinedExtendedClass : 5 occurrences
    // PhanUnreferencedClass : 4 occurrences
    // PhanUnusedPublicMethodParameter : 4 occurrences
    // PhanUndeclaredStaticMethod : 3 occurrences
    // PhanUnextractableAnnotationElementName : 3 occurrences
    // PhanUnusedPublicFinalMethodParameter : 3 occurrences
    // PhanParamSignatureMismatch : 2 occurrences
    // PhanNonClassMethodCall : 1 occurrence
    // PhanPossiblyInfiniteRecursionSameParams : 1 occurrence
    // PhanRedefinedInheritedInterface : 1 occurrence
    // PhanTypeMismatchArgumentReal : 1 occurrence
    // PhanTypeMismatchDeclaredReturnNullable : 1 occurrence
    // PhanTypeMismatchReturnProbablyReal : 1 occurrence
    // PhanUndeclaredExtendedClass : 1 occurrence
    // PhanUndeclaredProperty : 1 occurrence
    // PhanUndeclaredTypeReturnType : 1 occurrence
    // PhanUnusedVariableCaughtException : 1 occurrence
    // PhanWriteOnlyPublicProperty : 1 occurrence

    // Currently, file_suppressions and directory_suppressions are the only supported suppressions
    'file_suppressions' => [
        'dev/Command/CheckCommand.php' => ['PhanRedefinedClassReference', 'PhanRedefinedExtendedClass', 'PhanTypeMismatchArgumentNullable', 'PhanUnextractableAnnotationElementName', 'PhanUnextractableAnnotationSuffix'],
        'dev/Doctrine/MappingFilesLocator.php' => ['PhanParamSignatureMismatch', 'PhanRedefinedClassReference', 'PhanRedefinedInheritedInterface', 'PhanUnusedPublicMethodParameter'],
        'dev/Helper/MappingHelper.php' => ['PhanRedefinedClassReference', 'PhanUnusedVariableCaughtException'],
        'dev/Helper/ReflectionHelper.php' => ['PhanRedefinedClassReference', 'PhanTypeMismatchArgumentNullable', 'PhanUnextractableAnnotationSuffix', 'PhanUnreferencedPublicMethod'],
        'dev/Helper/StaticHelper.php' => ['PhanRedefinedClassReference'],
        'src/Controller/WebhookController.php' => ['PhanRedefinedClassReference', 'PhanUndeclaredMethod', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
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
        'src/Manager/StripeManager.php' => ['PhanNonClassMethodCall', 'PhanPossiblyInfiniteRecursionSameParams', 'PhanRedefinedClassReference', 'PhanTypeArraySuspiciousNullable', 'PhanTypeMismatchDeclaredReturn', 'PhanTypeMismatchDeclaredReturnNullable', 'PhanTypeMismatchReturnProbablyReal', 'PhanUnreferencedPublicMethod', 'PhanWriteOnlyPublicProperty'],
        'src/Model/StripeLocalCard.php' => ['PhanReadOnlyPrivateProperty', 'PhanRedefinedClassReference', 'PhanUnreferencedPublicClassConstant', 'PhanUnreferencedPublicMethod', 'PhanUnusedPublicMethodParameter'],
        'src/Model/StripeLocalCharge.php' => ['PhanReadOnlyPrivateProperty', 'PhanTypeMismatchDeclaredReturn', 'PhanUnreferencedPublicClassConstant', 'PhanUnreferencedPublicMethod'],
        'src/Model/StripeLocalCustomer.php' => ['PhanReadOnlyPrivateProperty', 'PhanRedefinedClassReference', 'PhanTypeMismatchArgumentNullable', 'PhanTypeMismatchDeclaredReturn', 'PhanUnreferencedPublicClassConstant', 'PhanUnreferencedPublicMethod'],
        'src/Model/StripeLocalWebhookEvent.php' => ['PhanReadOnlyPrivateProperty', 'PhanTypeMismatchDeclaredReturn', 'PhanUnusedPublicMethodParameter'],
        'src/Repository/StripeLocalCardRepository.php' => ['PhanRedefinedExtendedClass', 'PhanTypeMismatchDeclaredReturn'],
        'src/Repository/StripeLocalChargeRepository.php' => ['PhanRedefinedExtendedClass', 'PhanTypeMismatchDeclaredReturn'],
        'src/Repository/StripeLocalCustomerRepository.php' => ['PhanRedefinedExtendedClass', 'PhanTypeMismatchDeclaredReturn'],
        'src/Repository/StripeLocalWebhookEventRepository.php' => ['PhanRedefinedExtendedClass', 'PhanTypeMismatchDeclaredReturn'],
        'src/Subscriber/StripeChargeSubscriber.php' => ['PhanTypeMismatchArgumentNullable', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'src/Subscriber/StripeCustomerSubscriber.php' => ['PhanTypeMismatchArgumentNullable', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'src/Syncer/AbstractSyncer.php' => ['PhanRedefinedClassReference', 'PhanTypeMismatchDeclaredReturn', 'PhanUndeclaredMethod', 'PhanUndeclaredTypeReturnType'],
        'src/Syncer/ChargeSyncer.php' => ['PhanRedefinedClassReference', 'PhanUndeclaredMethod'],
        'src/Syncer/CustomerSyncer.php' => ['PhanRedefinedClassReference', 'PhanUndeclaredMethod'],
        'src/Syncer/WebhookEventSyncer.php' => ['PhanRedefinedClassReference', 'PhanUndeclaredMethod', 'PhanUnusedPublicFinalMethodParameter'],
        'tests/DependencyInjection/AbstractStripeBundleExtensionTest.php' => ['PhanUnreferencedPublicMethod'],
        'tests/DependencyInjection/YamlStripeBundleExtensionTest.php' => ['PhanRedefinedClassReference'],
        'tests/Event/AbstractStripeChargeEventTest.php' => ['PhanTypeMismatchArgument', 'PhanUnreferencedPublicMethod'],
        'tests/Event/AbstractStripeCustomerEventTest.php' => ['PhanTypeMismatchArgument', 'PhanUnreferencedPublicMethod'],
        'tests/Event/AbstractStripeWebhookEventEventTest.php' => ['PhanTypeMismatchArgument', 'PhanUnreferencedPublicMethod'],
        'tests/Form/Type/CreditCardStripeTokenTypeTest.php' => ['PhanUndeclaredExtendedClass', 'PhanUndeclaredProperty', 'PhanUndeclaredStaticMethod', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalCardTest.php' => ['PhanRedefinedClassReference', 'PhanTypeMismatchArgument', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalChargeTest.php' => ['PhanTypeMismatchArgument', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalCustomerTest.php' => ['PhanRedefinedClassReference', 'PhanTypeMismatchArgument', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalWebhookEventTest.php' => ['PhanUnreferencedPublicMethod'],
    ],
    // 'directory_suppressions' => ['src/directory_name' => ['PhanIssueName1', 'PhanIssueName2']] can be manually added if needed.
    // (directory_suppressions will currently be ignored by subsequent calls to --save-baseline, but may be preserved in future Phan releases)
];
