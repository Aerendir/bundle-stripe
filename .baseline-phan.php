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
    // PhanTypeMismatchArgument : 40+ occurrences
    // PhanAccessMethodInternal : 15+ occurrences
    // PhanParamTooMany : 15+ occurrences
    // PhanPluginUnreachableCode : 15+ occurrences
    // PhanDeprecatedFunction : 10+ occurrences
    // PhanTypeMissingReturn : 9 occurrences
    // PhanTypeMismatchDeclaredParam : 8 occurrences
    // PhanUnreferencedClass : 7 occurrences
    // PhanUnusedPublicNoOverrideMethodParameter : 7 occurrences
    // PhanRedefinedExtendedClass : 6 occurrences
    // PhanTypeMismatchReturn : 6 occurrences
    // PhanParamReqAfterOpt : 5 occurrences
    // PhanTypeMismatchArgumentNullable : 5 occurrences
    // PhanUnusedPublicMethodParameter : 5 occurrences
    // PhanTypeArraySuspiciousNullable : 4 occurrences
    // PhanDeprecatedClass : 3 occurrences
    // PhanNoopNew : 3 occurrences
    // PhanUndeclaredProperty : 3 occurrences
    // PhanUndeclaredStaticMethod : 3 occurrences
    // PhanTypeInvalidUnaryOperandIncOrDec : 2 occurrences
    // PhanTypeMismatchArgumentReal : 2 occurrences
    // PhanUndeclaredClassMethod : 2 occurrences
    // PhanUndeclaredClassReference : 2 occurrences
    // PhanAccessClassInternal : 1 occurrence
    // PhanCommentParamWithoutRealParam : 1 occurrence
    // PhanNonClassMethodCall : 1 occurrence
    // PhanParamSignatureMismatch : 1 occurrence
    // PhanPossiblyInfiniteRecursionSameParams : 1 occurrence
    // PhanTypeInvalidLeftOperandOfAdd : 1 occurrence
    // PhanTypeMismatchArgumentInternal : 1 occurrence
    // PhanTypeMismatchDeclaredParamNullable : 1 occurrence
    // PhanTypeMismatchDeclaredReturn : 1 occurrence
    // PhanTypeMismatchProperty : 1 occurrence
    // PhanUndeclaredExtendedClass : 1 occurrence
    // PhanUndeclaredMethod : 1 occurrence
    // PhanUndeclaredTypeReturnType : 1 occurrence
    // PhanUnextractableAnnotation : 1 occurrence
    // PhanUnusedVariableCaughtException : 1 occurrence

    // Currently, file_suppressions and directory_suppressions are the only supported suppressions
    'file_suppressions' => [
        'src/Command/StripeUpdatePlansCommand.php' => ['PhanAccessClassInternal', 'PhanDeprecatedFunction', 'PhanRedefinedClassReference', 'PhanTypeMismatchArgument', 'PhanTypeMissingReturn', 'PhanUndeclaredClassMethod'],
        'src/Controller/WebhookController.php' => ['PhanDeprecatedClass', 'PhanTypeArraySuspiciousNullable', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'src/DependencyInjection/Configuration.php' => ['PhanDeprecatedFunction'],
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
        'src/EventListener/StripeChargeSubscriber.php' => ['PhanDeprecatedFunction', 'PhanParamTooMany', 'PhanTypeMismatchArgument', 'PhanTypeMismatchArgumentNullable', 'PhanTypeMismatchDeclaredParam', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod', 'PhanUnusedPublicNoOverrideMethodParameter'],
        'src/EventListener/StripeCustomerSubscriber.php' => ['PhanDeprecatedFunction', 'PhanParamTooMany', 'PhanTypeMismatchArgument', 'PhanTypeMismatchArgumentNullable', 'PhanTypeMismatchDeclaredParam', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod', 'PhanUnusedPublicNoOverrideMethodParameter'],
        'src/EventListener/StripePlanSubscriber.php' => ['PhanDeprecatedFunction', 'PhanParamTooMany', 'PhanTypeMismatchArgument', 'PhanTypeMismatchDeclaredParam', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod', 'PhanUnusedPublicNoOverrideMethodParameter'],
        'src/EventListener/StripeSubscriptionSubscriber.php' => ['PhanDeprecatedFunction', 'PhanParamTooMany', 'PhanTypeMismatchArgument', 'PhanTypeMismatchArgumentNullable', 'PhanTypeMismatchDeclaredParam', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod', 'PhanUnusedPublicNoOverrideMethodParameter'],
        'src/Form/Type/CreditCardStripeTokenType.php' => ['PhanUnusedPublicMethodParameter'],
        'src/Model/StripeLocalCard.php' => ['PhanReadOnlyPrivateProperty', 'PhanRedefinedClassReference', 'PhanTypeMismatchReturn', 'PhanUnreferencedPublicMethod', 'PhanUnusedPublicMethodParameter'],
        'src/Model/StripeLocalCharge.php' => ['PhanReadOnlyPrivateProperty', 'PhanTypeMismatchReturn', 'PhanUnreferencedPublicMethod'],
        'src/Model/StripeLocalCustomer.php' => ['PhanReadOnlyPrivateProperty', 'PhanRedefinedClassReference', 'PhanTypeMismatchProperty', 'PhanUnreferencedPublicMethod'],
        'src/Model/StripeLocalPlan.php' => ['PhanUnextractableAnnotation', 'PhanUnreferencedPublicMethod'],
        'src/Model/StripeLocalSubscription.php' => ['PhanReadOnlyPrivateProperty', 'PhanTypeInvalidLeftOperandOfAdd', 'PhanTypeMismatchReturn', 'PhanUndeclaredProperty', 'PhanUnreferencedPublicMethod'],
        'src/Model/StripeLocalWebhookEvent.php' => ['PhanReadOnlyPrivateProperty', 'PhanUnusedPublicMethodParameter'],
        'src/Repository/StripeLocalCardRepository.php' => ['PhanRedefinedExtendedClass'],
        'src/Repository/StripeLocalChargeRepository.php' => ['PhanRedefinedExtendedClass'],
        'src/Repository/StripeLocalCustomerRepository.php' => ['PhanRedefinedExtendedClass'],
        'src/Repository/StripeLocalPlanRepository.php' => ['PhanRedefinedExtendedClass'],
        'src/Repository/StripeLocalSubscriptionRepository.php' => ['PhanRedefinedExtendedClass'],
        'src/Repository/StripeLocalWebhookEventRepository.php' => ['PhanRedefinedExtendedClass'],
        'src/SHQStripeBundle.php' => ['PhanUndeclaredClassReference', 'PhanUnreferencedClass'],
        'src/Service/EventGuesser.php' => ['PhanPluginUnreachableCode'],
        'src/Service/StripeManager.php' => ['PhanNonClassMethodCall', 'PhanParamReqAfterOpt', 'PhanPossiblyInfiniteRecursionSameParams', 'PhanReadOnlyPrivateProperty', 'PhanRedefinedClassReference', 'PhanTypeMismatchDeclaredParam', 'PhanTypeMismatchDeclaredParamNullable', 'PhanTypeMismatchDeclaredReturn', 'PhanUndeclaredProperty', 'PhanUndeclaredTypeReturnType', 'PhanUnreferencedPublicMethod'],
        'src/Syncer/AbstractSyncer.php' => ['PhanCommentParamWithoutRealParam', 'PhanRedefinedClassReference', 'PhanUnreferencedPublicMethod'],
        'src/Syncer/CardSyncer.php' => ['PhanParamSignatureMismatch', 'PhanTypeMissingReturn'],
        'src/Syncer/ChargeSyncer.php' => ['PhanRedefinedClassReference', 'PhanTypeMissingReturn'],
        'src/Syncer/CustomerSyncer.php' => ['PhanRedefinedClassReference', 'PhanTypeMismatchArgument', 'PhanTypeMismatchArgumentInternal', 'PhanTypeMismatchReturn', 'PhanTypeMissingReturn', 'PhanUnusedVariableCaughtException'],
        'src/Syncer/PlanSyncer.php' => ['PhanRedefinedClassReference', 'PhanTypeMissingReturn'],
        'src/Syncer/SubscriptionSyncer.php' => ['PhanRedefinedClassReference', 'PhanTypeMissingReturn'],
        'src/Syncer/WebhookEventSyncer.php' => ['PhanRedefinedClassReference', 'PhanTypeMismatchArgument', 'PhanTypeMissingReturn', 'PhanUndeclaredClassMethod', 'PhanUnusedPublicMethodParameter'],
        'tests/DependencyInjection/AbstractStripeBundleExtensionTest.php' => ['PhanUnreferencedPublicMethod'],
        'tests/DependencyInjection/YamlStripeBundleExtensionTest.php' => ['PhanAccessMethodInternal', 'PhanRedefinedClassReference'],
        'tests/Event/AbstractStripeChargeEventTest.php' => ['PhanAccessMethodInternal', 'PhanNoopNew', 'PhanTypeInvalidUnaryOperandIncOrDec', 'PhanTypeMismatchArgument', 'PhanUnreferencedPublicMethod'],
        'tests/Event/AbstractStripeCustomerEventTest.php' => ['PhanTypeMismatchArgument', 'PhanUnreferencedPublicMethod'],
        'tests/Event/AbstractStripePlanEventTest.php' => ['PhanTypeMismatchArgument', 'PhanUnreferencedPublicMethod'],
        'tests/Event/AbstractStripeSubscriptionEventTest.php' => ['PhanAccessMethodInternal', 'PhanNoopNew', 'PhanTypeMismatchArgument', 'PhanUnreferencedPublicMethod'],
        'tests/Event/AbstractStripeWebhookEventEventTest.php' => ['PhanTypeMismatchArgument', 'PhanUnreferencedPublicMethod'],
        'tests/Form/Type/CreditCardStripeTokenTypeTest.php' => ['PhanUndeclaredExtendedClass', 'PhanUndeclaredProperty', 'PhanUndeclaredStaticMethod', 'PhanUnreferencedClass', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalCardTest.php' => ['PhanRedefinedClassReference', 'PhanTypeMismatchArgument', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalChargeTest.php' => ['PhanAccessMethodInternal', 'PhanTypeMismatchArgument', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalCustomerTest.php' => ['PhanAccessMethodInternal', 'PhanRedefinedClassReference', 'PhanTypeMismatchArgument', 'PhanTypeMismatchArgumentReal', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalPlanTest.php' => ['PhanAccessMethodInternal', 'PhanTypeMismatchArgument', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalSubscriptionTest.php' => ['PhanAccessMethodInternal', 'PhanTypeMismatchArgument', 'PhanUnreferencedPublicMethod'],
        'tests/Model/StripeLocalWebhookEventTest.php' => ['PhanUnreferencedPublicMethod'],
    ],
    // 'directory_suppressions' => ['src/directory_name' => ['PhanIssueName1', 'PhanIssueName2']] can be manually added if needed.
    // (directory_suppressions will currently be ignored by subsequent calls to --save-baseline, but may be preserved in future Phan releases)
];
