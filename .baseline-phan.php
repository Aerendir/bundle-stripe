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
    // PhanRedefinedClassReference : 90+ occurrences
    // PhanUnreferencedPublicClassConstant : 75+ occurrences
    // PhanUnreferencedPublicMethod : 55+ occurrences
    // PhanReadOnlyPrivateProperty : 45+ occurrences
    // PhanTypeMismatchArgumentReal : 25+ occurrences
    // PhanPluginUnreachableCode : 15+ occurrences
    // PhanDeprecatedFunction : 10+ occurrences
    // PhanParamTooMany : 10+ occurrences
    // PhanTypeMismatchDeclaredReturn : 10+ occurrences
    // PhanUnusedPublicFinalMethodParameter : 10+ occurrences
    // PhanTypeMismatchDeclaredParam : 9 occurrences
    // PhanUnreferencedClass : 7 occurrences
    // PhanRedefinedExtendedClass : 6 occurrences
    // PhanParamReqAfterOpt : 5 occurrences
    // PhanTypeMismatchArgument : 5 occurrences
    // PhanTypeMismatchArgumentNullable : 5 occurrences
    // PhanDeprecatedClass : 3 occurrences
    // PhanNoopNew : 3 occurrences
    // PhanUndeclaredStaticMethod : 3 occurrences
    // PhanUndeclaredTypeReturnType : 2 occurrences
    // PhanWriteOnlyPublicProperty : 2 occurrences
    // PhanAccessClassInternal : 1 occurrence
    // PhanCommentParamWithoutRealParam : 1 occurrence
    // PhanNonClassMethodCall : 1 occurrence
    // PhanParamSignatureMismatch : 1 occurrence
    // PhanPossiblyInfiniteRecursionSameParams : 1 occurrence
    // PhanTypeInvalidLeftOperandOfAdd : 1 occurrence
    // PhanTypeMismatchArgumentInternal : 1 occurrence
    // PhanTypeMismatchDeclaredParamNullable : 1 occurrence
    // PhanUndeclaredClassMethod : 1 occurrence
    // PhanUndeclaredExtendedClass : 1 occurrence
    // PhanUndeclaredMethod : 1 occurrence
    // PhanUndeclaredProperty : 1 occurrence
    // PhanUndeclaredTypeProperty : 1 occurrence
    // PhanUnreferencedProtectedProperty : 1 occurrence
    // PhanUnusedVariableCaughtException : 1 occurrence
    // UndeclaredTypeInInlineVar : 1 occurrence

    // Currently, file_suppressions and directory_suppressions are the only supported suppressions
    'file_suppressions' => [
        'src/Command/StripeUpdatePlansCommand.php' => ['PhanAccessClassInternal', 'PhanDeprecatedFunction', 'PhanRedefinedClassReference', 'PhanTypeMismatchArgumentReal', 'PhanUndeclaredClassMethod', 'PhanUnreferencedProtectedProperty'],
        'src/Controller/WebhookController.php' => ['PhanDeprecatedClass', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'src/Event/AbstractStripeEvent.php' => ['PhanDeprecatedClass', 'PhanUnreferencedPublicMethod'],
        'src/Event/AbstractStripePlanEvent.php' => ['PhanDeprecatedClass'],
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
        'src/EventListener/StripeChargeSubscriber.php' => ['PhanDeprecatedFunction', 'PhanParamTooMany', 'PhanTypeMismatchArgumentNullable', 'PhanTypeMismatchDeclaredParam', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod', 'PhanUnusedPublicFinalMethodParameter'],
        'src/EventListener/StripeCustomerSubscriber.php' => ['PhanDeprecatedFunction', 'PhanParamTooMany', 'PhanTypeMismatchArgumentNullable', 'PhanTypeMismatchDeclaredParam', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod', 'PhanUnusedPublicFinalMethodParameter'],
        'src/EventListener/StripePlanSubscriber.php' => ['PhanDeprecatedFunction', 'PhanParamTooMany', 'PhanTypeMismatchDeclaredParam', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod', 'PhanUnusedPublicFinalMethodParameter'],
        'src/EventListener/StripeSubscriptionSubscriber.php' => ['PhanDeprecatedFunction', 'PhanParamTooMany', 'PhanTypeMismatchArgumentNullable', 'PhanTypeMismatchDeclaredParam', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod', 'PhanUnusedPublicFinalMethodParameter'],
        'src/Form/Type/CreditCardStripeTokenType.php' => ['PhanUnusedPublicFinalMethodParameter'],
        'src/Model/StripeLocalCard.php' => ['PhanReadOnlyPrivateProperty', 'PhanRedefinedClassReference', 'PhanUnreferencedPublicMethod', 'PhanUnusedPublicFinalMethodParameter'],
        'src/Model/StripeLocalCharge.php' => ['PhanReadOnlyPrivateProperty', 'PhanTypeMismatchDeclaredReturn', 'PhanUnreferencedPublicMethod'],
        'src/Model/StripeLocalCustomer.php' => ['PhanReadOnlyPrivateProperty', 'PhanRedefinedClassReference', 'PhanTypeMismatchArgumentReal', 'PhanTypeMismatchDeclaredReturn', 'PhanUnreferencedPublicMethod'],
        'src/Model/StripeLocalPlan.php' => ['PhanTypeMismatchDeclaredParam', 'PhanUndeclaredTypeProperty', 'PhanUndeclaredTypeReturnType', 'PhanUnreferencedPublicMethod', 'UndeclaredTypeInInlineVar'],
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
        'src/Service/StripeManager.php' => ['PhanNonClassMethodCall', 'PhanParamReqAfterOpt', 'PhanPossiblyInfiniteRecursionSameParams', 'PhanRedefinedClassReference', 'PhanTypeMismatchDeclaredParam', 'PhanTypeMismatchDeclaredParamNullable', 'PhanTypeMismatchDeclaredReturn', 'PhanUndeclaredTypeReturnType', 'PhanUnreferencedPublicMethod', 'PhanWriteOnlyPublicProperty'],
        'src/Syncer/AbstractSyncer.php' => ['PhanCommentParamWithoutRealParam', 'PhanRedefinedClassReference', 'PhanUnreferencedPublicMethod'],
        'src/Syncer/CardSyncer.php' => ['PhanParamSignatureMismatch'],
        'src/Syncer/ChargeSyncer.php' => ['PhanRedefinedClassReference'],
        'src/Syncer/CustomerSyncer.php' => ['PhanRedefinedClassReference', 'PhanTypeMismatchArgument', 'PhanTypeMismatchArgumentInternal', 'PhanUnusedVariableCaughtException'],
        'src/Syncer/PlanSyncer.php' => ['PhanRedefinedClassReference'],
        'src/Syncer/SubscriptionSyncer.php' => ['PhanRedefinedClassReference'],
        'src/Syncer/WebhookEventSyncer.php' => ['PhanRedefinedClassReference', 'PhanUnusedPublicFinalMethodParameter'],
        'tests/DependencyInjection/AbstractStripeBundleExtensionTest.php' => ['PhanUnreferencedPublicMethod'],
        'tests/DependencyInjection/YamlStripeBundleExtensionTest.php' => ['PhanRedefinedClassReference'],
        'tests/Event/AbstractStripeChargeEventTest.php' => ['PhanNoopNew', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Event/AbstractStripeCustomerEventTest.php' => ['PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Event/AbstractStripePlanEventTest.php' => ['PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Event/AbstractStripeSubscriptionEventTest.php' => ['PhanNoopNew', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Event/AbstractStripeWebhookEventEventTest.php' => ['PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Form/Type/CreditCardStripeTokenTypeTest.php' => ['PhanUndeclaredExtendedClass', 'PhanUndeclaredProperty', 'PhanUndeclaredStaticMethod', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalCardTest.php' => ['PhanRedefinedClassReference', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalChargeTest.php' => ['PhanTypeMismatchArgument', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalCustomerTest.php' => ['PhanRedefinedClassReference', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalPlanTest.php' => ['PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalSubscriptionTest.php' => ['PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalWebhookEventTest.php' => ['PhanUnreferencedPublicMethod'],
    ],
    // 'directory_suppressions' => ['src/directory_name' => ['PhanIssueName1', 'PhanIssueName2']] can be manually added if needed.
    // (directory_suppressions will currently be ignored by subsequent calls to --save-baseline, but may be preserved in future Phan releases)
];
