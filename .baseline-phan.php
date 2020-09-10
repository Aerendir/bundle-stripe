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
    // PhanRedefinedClassReference : 100+ occurrences
    // PhanUnreferencedPublicClassConstant : 70+ occurrences
    // PhanReadOnlyPrivateProperty : 30+ occurrences
    // PhanUnreferencedPublicMethod : 25+ occurrences
    // PhanTypeMismatchArgument : 15+ occurrences
    // PhanAccessMethodInternal : 10+ occurrences
    // PhanRedefinedExtendedClass : 10+ occurrences
    // PhanTypeMismatchDeclaredReturn : 9 occurrences
    // PhanTypeArraySuspiciousNullable : 6 occurrences
    // PhanUnusedPublicFinalMethodParameter : 6 occurrences
    // PhanUnreferencedClass : 4 occurrences
    // PhanTypeMismatchArgumentNullable : 3 occurrences
    // PhanTypeMismatchArgumentReal : 3 occurrences
    // PhanUndeclaredStaticMethod : 3 occurrences
    // PhanUnextractableAnnotationSuffix : 3 occurrences
    // PhanTypeMismatchDeclaredParam : 2 occurrences
    // PhanUndeclaredClassMethod : 2 occurrences
    // PhanUndeclaredMethod : 2 occurrences
    // PhanUnusedPublicMethodParameter : 2 occurrences
    // PhanNonClassMethodCall : 1 occurrence
    // PhanParamSignatureMismatch : 1 occurrence
    // PhanPossiblyInfiniteRecursionSameParams : 1 occurrence
    // PhanReadOnlyProtectedProperty : 1 occurrence
    // PhanTypeMismatchDeclaredReturnNullable : 1 occurrence
    // PhanTypeMismatchReturnProbablyReal : 1 occurrence
    // PhanTypeMismatchReturnReal : 1 occurrence
    // PhanUndeclaredExtendedClass : 1 occurrence
    // PhanUndeclaredProperty : 1 occurrence
    // PhanUndeclaredTypeParameter : 1 occurrence
    // PhanUnusedVariableCaughtException : 1 occurrence
    // PhanWriteOnlyPublicProperty : 1 occurrence

    // Currently, file_suppressions and directory_suppressions are the only supported suppressions
    'file_suppressions' => [
        'src/Command/ApiOutdatedCommand.php' => ['PhanReadOnlyProtectedProperty', 'PhanRedefinedClassReference', 'PhanRedefinedExtendedClass', 'PhanTypeMismatchReturnReal', 'PhanUnextractableAnnotationSuffix'],
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
        'src/Model/StripeLocalCustomer.php' => ['PhanReadOnlyPrivateProperty', 'PhanRedefinedClassReference', 'PhanTypeMismatchArgumentReal', 'PhanTypeMismatchDeclaredReturn', 'PhanUnreferencedPublicClassConstant', 'PhanUnreferencedPublicMethod'],
        'src/Model/StripeLocalWebhookEvent.php' => ['PhanReadOnlyPrivateProperty', 'PhanTypeMismatchDeclaredReturn', 'PhanUnusedPublicMethodParameter'],
        'src/Repository/StripeLocalCardRepository.php' => ['PhanRedefinedExtendedClass', 'PhanTypeMismatchDeclaredReturn'],
        'src/Repository/StripeLocalChargeRepository.php' => ['PhanRedefinedExtendedClass', 'PhanTypeMismatchDeclaredReturn'],
        'src/Repository/StripeLocalCustomerRepository.php' => ['PhanRedefinedExtendedClass', 'PhanTypeMismatchDeclaredReturn'],
        'src/Repository/StripeLocalWebhookEventRepository.php' => ['PhanRedefinedExtendedClass', 'PhanTypeMismatchDeclaredReturn'],
        'src/Subscriber/StripeChargeSubscriber.php' => ['PhanTypeMismatchArgumentNullable', 'PhanTypeMismatchDeclaredParam', 'PhanUndeclaredClassMethod', 'PhanUndeclaredTypeParameter', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod', 'PhanUnusedPublicFinalMethodParameter'],
        'src/Subscriber/StripeCustomerSubscriber.php' => ['PhanTypeMismatchArgumentNullable', 'PhanTypeMismatchDeclaredParam', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod', 'PhanUnusedPublicFinalMethodParameter'],
        'src/Syncer/AbstractSyncer.php' => ['PhanRedefinedClassReference'],
        'src/Syncer/CardSyncer.php' => ['PhanParamSignatureMismatch'],
        'src/Syncer/ChargeSyncer.php' => ['PhanRedefinedClassReference', 'PhanTypeMismatchArgument'],
        'src/Syncer/CustomerSyncer.php' => ['PhanRedefinedClassReference', 'PhanTypeMismatchArgument', 'PhanUnusedVariableCaughtException'],
        'src/Syncer/WebhookEventSyncer.php' => ['PhanRedefinedClassReference', 'PhanUnusedPublicFinalMethodParameter'],
        'tests/DependencyInjection/AbstractStripeBundleExtensionTest.php' => ['PhanRedefinedExtendedClass', 'PhanUnreferencedPublicMethod'],
        'tests/DependencyInjection/YamlStripeBundleExtensionTest.php' => ['PhanAccessMethodInternal', 'PhanRedefinedClassReference'],
        'tests/Event/AbstractStripeChargeEventTest.php' => ['PhanAccessMethodInternal', 'PhanRedefinedClassReference', 'PhanRedefinedExtendedClass', 'PhanTypeMismatchArgument', 'PhanUnreferencedPublicMethod'],
        'tests/Event/AbstractStripeCustomerEventTest.php' => ['PhanRedefinedExtendedClass', 'PhanTypeMismatchArgument', 'PhanUnreferencedPublicMethod'],
        'tests/Event/AbstractStripeWebhookEventEventTest.php' => ['PhanRedefinedExtendedClass', 'PhanTypeMismatchArgument', 'PhanUnreferencedPublicMethod'],
        'tests/Form/Type/CreditCardStripeTokenTypeTest.php' => ['PhanUndeclaredExtendedClass', 'PhanUndeclaredProperty', 'PhanUndeclaredStaticMethod', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalCardTest.php' => ['PhanRedefinedClassReference', 'PhanTypeMismatchArgument', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalChargeTest.php' => ['PhanAccessMethodInternal', 'PhanRedefinedClassReference', 'PhanTypeMismatchArgument', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalCustomerTest.php' => ['PhanAccessMethodInternal', 'PhanRedefinedClassReference', 'PhanTypeMismatchArgument', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalWebhookEventTest.php' => ['PhanUnreferencedPublicMethod'],
        'tests/ModelTestCase.php' => ['PhanRedefinedExtendedClass', 'PhanUndeclaredMethod'],
    ],
    // 'directory_suppressions' => ['src/directory_name' => ['PhanIssueName1', 'PhanIssueName2']] can be manually added if needed.
    // (directory_suppressions will currently be ignored by subsequent calls to --save-baseline, but may be preserved in future Phan releases)
];
