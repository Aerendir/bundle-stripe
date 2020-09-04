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
    // PhanRedefinedClassReference : 120+ occurrences
    // PhanUnreferencedPublicClassConstant : 75+ occurrences
    // PhanUnreferencedPublicMethod : 50+ occurrences
    // PhanReadOnlyPrivateProperty : 45+ occurrences
    // PhanUndeclaredClassMethod : 25+ occurrences
    // PhanAccessMethodInternal : 15+ occurrences
    // PhanPluginUnreachableCode : 15+ occurrences
    // PhanTypeMismatchArgumentReal : 15+ occurrences
    // PhanRedefinedExtendedClass : 10+ occurrences
    // PhanTypeMismatchDeclaredReturn : 10+ occurrences
    // PhanUndeclaredTypeThrowsType : 10+ occurrences
    // PhanUnusedPublicFinalMethodParameter : 10+ occurrences
    // PhanTypeMismatchDeclaredParam : 9 occurrences
    // PhanUndeclaredMethod : 8 occurrences
    // PhanUndeclaredTypeParameter : 8 occurrences
    // PhanUnreferencedClass : 6 occurrences
    // PhanParamReqAfterOpt : 5 occurrences
    // PhanTypeMismatchArgumentNullable : 5 occurrences
    // PhanTypeMismatchArgument : 3 occurrences
    // PhanTypeMismatchArgumentProbablyReal : 3 occurrences
    // PhanUndeclaredClassCatch : 3 occurrences
    // PhanUndeclaredClassInstanceof : 3 occurrences
    // PhanUndeclaredStaticMethod : 3 occurrences
    // PhanUndeclaredClassReference : 2 occurrences
    // PhanWriteOnlyPublicProperty : 2 occurrences
    // PhanAccessClassInternal : 1 occurrence
    // PhanNonClassMethodCall : 1 occurrence
    // PhanParamSignatureMismatch : 1 occurrence
    // PhanPossiblyInfiniteRecursionSameParams : 1 occurrence
    // PhanTypeInvalidLeftOperandOfAdd : 1 occurrence
    // PhanTypeMismatchDeclaredParamNullable : 1 occurrence
    // PhanTypeMismatchReturnNullable : 1 occurrence
    // PhanUndeclaredExtendedClass : 1 occurrence
    // PhanUndeclaredProperty : 1 occurrence
    // PhanUndeclaredTypeReturnType : 1 occurrence
    // PhanUnreferencedProtectedProperty : 1 occurrence
    // PhanUnusedVariableCaughtException : 1 occurrence

    // Currently, file_suppressions and directory_suppressions are the only supported suppressions
    'file_suppressions' => [
        'src/Command/StripeUpdatePlansCommand.php' => ['PhanAccessClassInternal', 'PhanRedefinedClassReference', 'PhanUndeclaredMethod', 'PhanUnreferencedProtectedProperty'],
        'src/Controller/WebhookController.php' => ['PhanRedefinedClassReference', 'PhanUnreferencedPublicMethod'],
        'src/Event/AbstractStripeEvent.php' => ['PhanUnreferencedPublicMethod'],
        'src/Event/AbstractStripeSubscriptionEvent.php' => ['PhanUndeclaredMethod'],
        'src/Event/StripeCustomerUpdateEvent.php' => ['PhanUnreferencedPublicMethod'],
        'src/Event/StripePlanUpdateEvent.php' => ['PhanUnreferencedPublicMethod'],
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
        'src/Event/StripeWebhookPlanEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookProductEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookRecipientEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookReviewEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookSkuEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookSourceEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/Event/StripeWebhookTransferEventEvent.php' => ['PhanUnreferencedPublicClassConstant'],
        'src/EventListener/StripeChargeSubscriber.php' => ['PhanTypeMismatchArgumentNullable', 'PhanTypeMismatchDeclaredParam', 'PhanUndeclaredClassMethod', 'PhanUndeclaredTypeParameter', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod', 'PhanUnusedPublicFinalMethodParameter'],
        'src/EventListener/StripeCustomerSubscriber.php' => ['PhanTypeMismatchArgumentNullable', 'PhanTypeMismatchDeclaredParam', 'PhanUndeclaredClassMethod', 'PhanUndeclaredTypeParameter', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod', 'PhanUnusedPublicFinalMethodParameter'],
        'src/EventListener/StripePlanSubscriber.php' => ['PhanTypeMismatchDeclaredParam', 'PhanUndeclaredClassMethod', 'PhanUndeclaredTypeParameter', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod', 'PhanUnusedPublicFinalMethodParameter'],
        'src/EventListener/StripeSubscriptionSubscriber.php' => ['PhanTypeMismatchArgumentNullable', 'PhanTypeMismatchDeclaredParam', 'PhanUndeclaredClassMethod', 'PhanUndeclaredTypeParameter', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod', 'PhanUnusedPublicFinalMethodParameter'],
        'src/Form/Type/CreditCardStripeTokenType.php' => ['PhanUnusedPublicFinalMethodParameter'],
        'src/Model/StripeLocalCard.php' => ['PhanReadOnlyPrivateProperty', 'PhanRedefinedClassReference', 'PhanUnreferencedPublicMethod', 'PhanUnusedPublicFinalMethodParameter'],
        'src/Model/StripeLocalCharge.php' => ['PhanReadOnlyPrivateProperty', 'PhanTypeMismatchDeclaredReturn', 'PhanUnreferencedPublicMethod'],
        'src/Model/StripeLocalCustomer.php' => ['PhanReadOnlyPrivateProperty', 'PhanRedefinedClassReference', 'PhanTypeMismatchArgumentReal', 'PhanTypeMismatchDeclaredReturn', 'PhanUnreferencedPublicMethod'],
        'src/Model/StripeLocalPlan.php' => ['PhanTypeMismatchDeclaredParam', 'PhanTypeMismatchDeclaredReturn', 'PhanTypeMismatchReturnNullable', 'PhanUnreferencedPublicMethod'],
        'src/Model/StripeLocalSubscription.php' => ['PhanReadOnlyPrivateProperty', 'PhanTypeInvalidLeftOperandOfAdd', 'PhanTypeMismatchDeclaredReturn', 'PhanUnreferencedPublicMethod', 'PhanWriteOnlyPublicProperty'],
        'src/Model/StripeLocalWebhookEvent.php' => ['PhanReadOnlyPrivateProperty', 'PhanTypeMismatchDeclaredReturn', 'PhanUnusedPublicFinalMethodParameter'],
        'src/Repository/StripeLocalCardRepository.php' => ['PhanRedefinedExtendedClass', 'PhanTypeMismatchDeclaredReturn'],
        'src/Repository/StripeLocalChargeRepository.php' => ['PhanRedefinedExtendedClass', 'PhanTypeMismatchDeclaredReturn'],
        'src/Repository/StripeLocalCustomerRepository.php' => ['PhanRedefinedExtendedClass', 'PhanTypeMismatchDeclaredReturn'],
        'src/Repository/StripeLocalPlanRepository.php' => ['PhanRedefinedExtendedClass', 'PhanTypeMismatchDeclaredReturn'],
        'src/Repository/StripeLocalSubscriptionRepository.php' => ['PhanRedefinedExtendedClass', 'PhanTypeMismatchDeclaredReturn'],
        'src/Repository/StripeLocalWebhookEventRepository.php' => ['PhanRedefinedExtendedClass', 'PhanTypeMismatchDeclaredReturn'],
        'src/SHQStripeBundle.php' => ['PhanUnreferencedClass'],
        'src/Service/EventGuesser.php' => ['PhanPluginUnreachableCode'],
        'src/Service/StripeManager.php' => ['PhanNonClassMethodCall', 'PhanParamReqAfterOpt', 'PhanPossiblyInfiniteRecursionSameParams', 'PhanRedefinedClassReference', 'PhanTypeMismatchDeclaredParam', 'PhanTypeMismatchDeclaredParamNullable', 'PhanTypeMismatchDeclaredReturn', 'PhanUndeclaredClassCatch', 'PhanUndeclaredClassMethod', 'PhanUndeclaredClassReference', 'PhanUndeclaredTypeParameter', 'PhanUndeclaredTypeReturnType', 'PhanUndeclaredTypeThrowsType', 'PhanUnreferencedPublicMethod', 'PhanWriteOnlyPublicProperty'],
        'src/Syncer/AbstractSyncer.php' => ['PhanRedefinedClassReference', 'PhanUnreferencedPublicMethod'],
        'src/Syncer/CardSyncer.php' => ['PhanParamSignatureMismatch', 'PhanUndeclaredMethod'],
        'src/Syncer/ChargeSyncer.php' => ['PhanRedefinedClassReference', 'PhanTypeMismatchArgument', 'PhanUndeclaredClassInstanceof', 'PhanUndeclaredMethod'],
        'src/Syncer/CustomerSyncer.php' => ['PhanRedefinedClassReference', 'PhanTypeMismatchArgument', 'PhanUndeclaredClassCatch', 'PhanUndeclaredClassInstanceof', 'PhanUndeclaredMethod', 'PhanUnusedVariableCaughtException'],
        'src/Syncer/PlanSyncer.php' => ['PhanRedefinedClassReference'],
        'src/Syncer/SubscriptionSyncer.php' => ['PhanRedefinedClassReference'],
        'src/Syncer/WebhookEventSyncer.php' => ['PhanRedefinedClassReference', 'PhanUnusedPublicFinalMethodParameter'],
        'tests/DependencyInjection/AbstractStripeBundleExtensionTest.php' => ['PhanRedefinedExtendedClass', 'PhanUnreferencedPublicMethod'],
        'tests/DependencyInjection/YamlStripeBundleExtensionTest.php' => ['PhanAccessMethodInternal', 'PhanRedefinedClassReference'],
        'tests/Event/AbstractStripeChargeEventTest.php' => ['PhanAccessMethodInternal', 'PhanRedefinedClassReference', 'PhanRedefinedExtendedClass', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Event/AbstractStripeCustomerEventTest.php' => ['PhanRedefinedExtendedClass', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Event/AbstractStripePlanEventTest.php' => ['PhanRedefinedExtendedClass', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Event/AbstractStripeSubscriptionEventTest.php' => ['PhanAccessMethodInternal', 'PhanRedefinedClassReference', 'PhanRedefinedExtendedClass', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Event/AbstractStripeWebhookEventEventTest.php' => ['PhanRedefinedExtendedClass', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Form/Type/CreditCardStripeTokenTypeTest.php' => ['PhanUndeclaredExtendedClass', 'PhanUndeclaredProperty', 'PhanUndeclaredStaticMethod', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalCardTest.php' => ['PhanRedefinedClassReference', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalChargeTest.php' => ['PhanAccessMethodInternal', 'PhanRedefinedClassReference', 'PhanTypeMismatchArgument', 'PhanTypeMismatchArgumentProbablyReal', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalCustomerTest.php' => ['PhanAccessMethodInternal', 'PhanRedefinedClassReference', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalPlanTest.php' => ['PhanAccessMethodInternal', 'PhanRedefinedClassReference', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalSubscriptionTest.php' => ['PhanAccessMethodInternal', 'PhanRedefinedClassReference', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalWebhookEventTest.php' => ['PhanUnreferencedPublicMethod'],
        'tests/ModelTestCase.php' => ['PhanRedefinedExtendedClass'],
    ],
    // 'directory_suppressions' => ['src/directory_name' => ['PhanIssueName1', 'PhanIssueName2']] can be manually added if needed.
    // (directory_suppressions will currently be ignored by subsequent calls to --save-baseline, but may be preserved in future Phan releases)
];
