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
    // PhanUnreferencedPublicClassConstant : 70+ occurrences
    // PhanUnreferencedPublicMethod : 55+ occurrences
    // PhanReadOnlyPrivateProperty : 30+ occurrences
    // PhanTypeArraySuspiciousNullable : 7 occurrences
    // PhanTypeMismatchDeclaredReturn : 6 occurrences
    // PhanGenericMissingParameters : 4 occurrences
    // PhanUnusedPublicMethodParameter : 4 occurrences
    // PhanTypeMismatchDeclaredParam : 3 occurrences
    // PhanUndeclaredStaticMethod : 3 occurrences
    // PhanUnusedPublicFinalMethodParameter : 3 occurrences
    // PhanParamSignatureMismatch : 2 occurrences
    // PhanParamSignatureRealMismatchReturnType : 2 occurrences
    // PhanTypeMismatchPropertyProbablyReal : 2 occurrences
    // PhanTypeMismatchReturnSuperType : 2 occurrences
    // PhanUndeclaredTypeReturnType : 2 occurrences
    // PhanPossiblyInfiniteRecursionSameParams : 1 occurrence
    // PhanTypeMismatchArgumentInternalReal : 1 occurrence
    // PhanTypeMismatchPropertyReal : 1 occurrence
    // PhanTypeMismatchReturn : 1 occurrence
    // PhanTypeMismatchReturnReal : 1 occurrence
    // PhanUndeclaredClassInstanceof : 1 occurrence
    // PhanUndeclaredExtendedClass : 1 occurrence
    // PhanUndeclaredMethod : 1 occurrence
    // PhanUndeclaredProperty : 1 occurrence
    // PhanWriteOnlyPublicProperty : 1 occurrence

    'file_suppressions' => [
        'dev/Command/CheckCommand.php' => [
            'PhanTypeMismatchDeclaredParam' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Dev\\Command\\CheckCommand::compareTypes', '\\SerendipityHQ\\Bundle\\StripeBundle\\Dev\\Command\\CheckCommand::extractTypes']
        ],
        'dev/Doctrine/MappingFilesLocator.php' => [
            'PhanParamSignatureMismatch' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Dev\\Doctrine\\MappingFilesLocator::fileExists', '\\SerendipityHQ\\Bundle\\StripeBundle\\Dev\\Doctrine\\MappingFilesLocator::getAllClassNames'],
            'PhanParamSignatureRealMismatchReturnType' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Dev\\Doctrine\\MappingFilesLocator::fileExists', '\\SerendipityHQ\\Bundle\\StripeBundle\\Dev\\Doctrine\\MappingFilesLocator::getAllClassNames'],
            'PhanUnusedPublicMethodParameter' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Dev\\Doctrine\\MappingFilesLocator::fileExists', '\\SerendipityHQ\\Bundle\\StripeBundle\\Dev\\Doctrine\\MappingFilesLocator::getAllClassNames']
        ],
        'dev/Helper/MappingHelper.php' => [
            'PhanTypeMismatchReturnReal' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Dev\\Helper\\MappingHelper::getMappedProperty']
        ],
        'dev/Helper/ReflectionHelper.php' => [
            'PhanTypeMismatchPropertyReal' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Dev\\Helper\\ReflectionHelper::getDockBlockFactory'],
            'PhanTypeMismatchReturn' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Dev\\Helper\\ReflectionHelper::getSdkModelPropertiesDocComments'],
            'PhanUndeclaredTypeReturnType' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Dev\\Helper\\ReflectionHelper::getSdkModelPropertiesDocComments'],
            'PhanUnreferencedPublicMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Dev\\Helper\\ReflectionHelper::getLocalModelReflectedProperty']
        ],
        'src/Controller/WebhookController.php' => [
            'PhanUndeclaredMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Controller\\WebhookController::notifyAction'],
            'PhanUnreferencedPublicMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Controller\\WebhookController::notifyAction']
        ],
        'src/Event/AbstractStripeEvent.php' => [
            'PhanUnreferencedPublicMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\AbstractStripeEvent::getStopReason']
        ],
        'src/Event/StripeCustomerUpdateEvent.php' => [
            'PhanUnreferencedPublicMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeCustomerUpdateEvent::notSyncSources', '\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeCustomerUpdateEvent::syncSources']
        ],
        'src/Event/StripeWebhookAccountEventEvent.php' => [
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeWebhookAccountEventEvent']
        ],
        'src/Event/StripeWebhookApplicationFeeEventEvent.php' => [
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeWebhookApplicationFeeEventEvent']
        ],
        'src/Event/StripeWebhookBalanceEventEvent.php' => [
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeWebhookBalanceEventEvent']
        ],
        'src/Event/StripeWebhookBitcoinEventEvent.php' => [
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeWebhookBitcoinEventEvent']
        ],
        'src/Event/StripeWebhookChargeEventEvent.php' => [
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeWebhookChargeEventEvent']
        ],
        'src/Event/StripeWebhookCouponEventEvent.php' => [
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeWebhookCouponEventEvent']
        ],
        'src/Event/StripeWebhookCustomerEventEvent.php' => [
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeWebhookCustomerEventEvent']
        ],
        'src/Event/StripeWebhookInvoiceEventEvent.php' => [
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeWebhookInvoiceEventEvent']
        ],
        'src/Event/StripeWebhookInvoiceItemEventEvent.php' => [
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeWebhookInvoiceItemEventEvent']
        ],
        'src/Event/StripeWebhookOrderEventEvent.php' => [
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeWebhookOrderEventEvent']
        ],
        'src/Event/StripeWebhookOrderReturnEventEvent.php' => [
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeWebhookOrderReturnEventEvent']
        ],
        'src/Event/StripeWebhookPingEventEvent.php' => [
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeWebhookPingEventEvent']
        ],
        'src/Event/StripeWebhookProductEventEvent.php' => [
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeWebhookProductEventEvent']
        ],
        'src/Event/StripeWebhookRecipientEventEvent.php' => [
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeWebhookRecipientEventEvent']
        ],
        'src/Event/StripeWebhookReviewEvent.php' => [
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeWebhookReviewEvent']
        ],
        'src/Event/StripeWebhookSkuEventEvent.php' => [
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeWebhookSkuEventEvent']
        ],
        'src/Event/StripeWebhookSourceEventEvent.php' => [
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeWebhookSourceEventEvent']
        ],
        'src/Event/StripeWebhookTransferEventEvent.php' => [
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Event\\StripeWebhookTransferEventEvent']
        ],
        'src/Form/Type/CreditCardStripeTokenType.php' => [
            'PhanUnusedPublicFinalMethodParameter' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Form\\Type\\CreditCardStripeTokenType::buildForm']
        ],
        'src/Manager/StripeManager.php' => [
            'PhanPossiblyInfiniteRecursionSameParams' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Manager\\StripeManager::callStripeApi'],
            'PhanTypeArraySuspiciousNullable' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Manager\\StripeManager::handleException'],
            'PhanUnreferencedPublicMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Manager\\StripeManager::hasErrors'],
            'PhanWriteOnlyPublicProperty' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Manager\\StripeManager']
        ],
        'src/Model/StripeLocalCard.php' => [
            'PhanReadOnlyPrivateProperty' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCard'],
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCard'],
            'PhanUnreferencedPublicMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCard::getError'],
            'PhanUnusedPublicMethodParameter' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCard::toStripe']
        ],
        'src/Model/StripeLocalCharge.php' => [
            'PhanReadOnlyPrivateProperty' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge'],
            'PhanTypeMismatchReturnSuperType' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::getAmount', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::getAmountRefunded'],
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge'],
            'PhanUnreferencedPublicMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::getAmountRefunded', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::getBillingDetails', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::getCalculatedStatementDescriptor', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::getOutcome', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::getPaymentMethod', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::getPaymentMethodDetails', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::getReceiptUrl', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::getRefunds', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::getReview', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::getStatementDescriptorSuffix', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::isCapture', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::isDisputed', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::isRefunded', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::setAmountRefunded', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::setBillingDetails', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::setCalculatedStatementDescriptor', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::setCapture', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::setDescription', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::setDisputed', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::setMetadata', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::setPaymentMethod', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::setPaymentMethodDetails', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::setReceiptUrl', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::setRefunded', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::setRefunds', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::setReview', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCharge::setStatementDescriptorSuffix']
        ],
        'src/Model/StripeLocalCustomer.php' => [
            'PhanReadOnlyPrivateProperty' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCustomer'],
            'PhanTypeMismatchArgumentInternalReal' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCustomer::metadataTransformer'],
            'PhanUnreferencedPublicClassConstant' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCustomer'],
            'PhanUnreferencedPublicMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCustomer::getAddress', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCustomer::getPhone', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCustomer::getSources', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCustomer::metadataTransformer', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCustomer::setAddress', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCustomer::setName', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCustomer::setPhone', '\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalCustomer::setSources']
        ],
        'src/Model/StripeLocalWebhookEvent.php' => [
            'PhanReadOnlyPrivateProperty' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalWebhookEvent'],
            'PhanUnusedPublicMethodParameter' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Model\\StripeLocalWebhookEvent::toStripe']
        ],
        'src/Repository/StripeLocalCardRepository.php' => [
            'PhanGenericMissingParameters' => ['src/Repository/StripeLocalCardRepository.php'],
            'PhanTypeMismatchDeclaredReturn' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Repository\\StripeLocalCardRepository::findOneByStripeId']
        ],
        'src/Repository/StripeLocalChargeRepository.php' => [
            'PhanGenericMissingParameters' => ['src/Repository/StripeLocalChargeRepository.php'],
            'PhanTypeMismatchDeclaredReturn' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Repository\\StripeLocalChargeRepository::findOneByStripeId']
        ],
        'src/Repository/StripeLocalCustomerRepository.php' => [
            'PhanGenericMissingParameters' => ['src/Repository/StripeLocalCustomerRepository.php'],
            'PhanTypeMismatchDeclaredReturn' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Repository\\StripeLocalCustomerRepository::findOneByStripeId']
        ],
        'src/Repository/StripeLocalWebhookEventRepository.php' => [
            'PhanGenericMissingParameters' => ['src/Repository/StripeLocalWebhookEventRepository.php'],
            'PhanTypeMismatchDeclaredReturn' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Repository\\StripeLocalWebhookEventRepository::findOneByStripeId']
        ],
        'src/Subscriber/StripeChargeSubscriber.php' => [
            'PhanUnreferencedPublicMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Subscriber\\StripeChargeSubscriber::onChargeCreate']
        ],
        'src/Subscriber/StripeCustomerSubscriber.php' => [
            'PhanUnreferencedPublicMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Subscriber\\StripeCustomerSubscriber::onCustomerCreate', '\\SerendipityHQ\\Bundle\\StripeBundle\\Subscriber\\StripeCustomerSubscriber::onCustomerUpdate']
        ],
        'src/Syncer/AbstractSyncer.php' => [
            'PhanTypeMismatchDeclaredReturn' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Syncer\\AbstractSyncer::getLocalCustomer'],
            'PhanUndeclaredTypeReturnType' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Syncer\\AbstractSyncer::getLocalCustomer']
        ],
        'src/Syncer/CardSyncer.php' => [
            'PhanUndeclaredClassInstanceof' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Syncer\\CardSyncer::syncLocalFromStripe']
        ],
        'src/Syncer/CustomerSyncer.php' => [
            'PhanTypeMismatchPropertyProbablyReal' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Syncer\\CustomerSyncer::syncStripeFromLocal']
        ],
        'src/Syncer/WebhookEventSyncer.php' => [
            'PhanUnusedPublicFinalMethodParameter' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Syncer\\WebhookEventSyncer::syncStripeFromLocal']
        ],
        'tests/DependencyInjection/AbstractStripeBundleExtensionTest.php' => [
            'PhanTypeArraySuspiciousNullable' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Tests\\DependencyInjection\\AbstractStripeBundleExtensionTest::testDefaultConfig'],
            'PhanUnreferencedPublicMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Tests\\DependencyInjection\\AbstractStripeBundleExtensionTest::testDefaultConfig']
        ],
        'tests/Event/AbstractStripeChargeEventTest.php' => [
            'PhanUnreferencedPublicMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Tests\\Event\\AbstractStripeChargeEventTest::testAbstractStripeChargeEvent']
        ],
        'tests/Event/AbstractStripeCustomerEventTest.php' => [
            'PhanUnreferencedPublicMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Tests\\Event\\AbstractStripeCustomerEventTest::testAbstractStripeCustomerEvent']
        ],
        'tests/Event/AbstractStripeWebhookEventEventTest.php' => [
            'PhanUnreferencedPublicMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Tests\\Event\\AbstractStripeWebhookEventEventTest::testAbstractStripeWebhookEventEvent']
        ],
        'tests/Form/Type/CreditCardStripeTokenTypeTest.php' => [
            'PhanUndeclaredExtendedClass' => ['tests/Form/Type/CreditCardStripeTokenTypeTest.php'],
            'PhanUndeclaredProperty' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Tests\\Form\\Type\\CreditCardStripeTokenTypeTest::testSubmitValidData'],
            'PhanUndeclaredStaticMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Tests\\Form\\Type\\CreditCardStripeTokenTypeTest::testSubmitValidData'],
            'PhanUnreferencedPublicMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Tests\\Form\\Type\\CreditCardStripeTokenTypeTest::testSubmitValidData']
        ],
        'tests/Model/StripeLocalCardTest.php' => [
            'PhanUnreferencedPublicMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Tests\\Model\\StripeLocalCardTest::testStripeLocalCharge']
        ],
        'tests/Model/StripeLocalChargeTest.php' => [
            'PhanUnreferencedPublicMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Tests\\Model\\StripeLocalChargeTest::testStripeLocalCharge', '\\SerendipityHQ\\Bundle\\StripeBundle\\Tests\\Model\\StripeLocalChargeTest::testToStripeCreateFullArray']
        ],
        'tests/Model/StripeLocalCustomerTest.php' => [
            'PhanUnreferencedPublicMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Tests\\Model\\StripeLocalCustomerTest::testSetNewSourceThrowsAnExceptionWithAnInvalidTokenString', '\\SerendipityHQ\\Bundle\\StripeBundle\\Tests\\Model\\StripeLocalCustomerTest::testStripeLocalCustomer', '\\SerendipityHQ\\Bundle\\StripeBundle\\Tests\\Model\\StripeLocalCustomerTest::testToStringThrowsAnExceptionWithAnInvalidAction']
        ],
        'tests/Model/StripeLocalWebhookEventTest.php' => [
            'PhanUnreferencedPublicMethod' => ['\\SerendipityHQ\\Bundle\\StripeBundle\\Tests\\Model\\StripeLocalWebhookEventTest::testSetNewSourceThrowsAnExceptionWithAnInvalidTokenString', '\\SerendipityHQ\\Bundle\\StripeBundle\\Tests\\Model\\StripeLocalWebhookEventTest::testStripeLocalWebhookEvent', '\\SerendipityHQ\\Bundle\\StripeBundle\\Tests\\Model\\StripeLocalWebhookEventTest::testToStringThrowsAnExceptionWithAnInvalidAction']
        ],
    ],
    // 'directory_suppressions' => ['src/directory_name' => ['PhanIssueName1', 'PhanIssueName2']] can be manually added if needed.
    // (directory_suppressions will currently be ignored by subsequent calls to --save-baseline, but may be preserved in future Phan releases)
];
