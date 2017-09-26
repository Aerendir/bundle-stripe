<?php

/*
 * This file is part of the SHQStripeBundle.
 *
 * Copyright Adamo Aerendir Crespi 2016-2017.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    Adamo Aerendir Crespi <hello@aerendir.me>
 * @copyright Copyright (C) 2016 - 2017 Aerendir. All rights reserved.
 * @license   MIT License.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Tests\Model;

use Money\Currency;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCard;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Bundle\StripeBundle\Tests\ModelTestCase;
use SerendipityHQ\Component\ValueObjects\Email\Email;
use SerendipityHQ\Component\ValueObjects\Money\Money;

/**
 * Tests the StripeLocalCharge entity.
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
class StripeLocalChargeTest extends ModelTestCase
{
    public function testStripeLocalCharge()
    {
        $resource = new StripeLocalCharge();

        $mockCard = $this->createMock(StripeLocalCard::class);
        $mockCard->method('getId')->willReturn('123');

        $test = [
            'id'                  => 'this_is_the_id',
            'amount'              => $this->createMock(Money::class),
            'balanceTransaction'  => '0',
            'created'             => $this->createMock(\DateTime::class),
            'customer'            => $this->createMock(StripeLocalCustomer::class),
            'description'         => 'the description',
            'failureCode'         => '123',
            'failureMessage'      => 'there ever is a reason',
            'fraudDetails'        => 'details about fraud',
            'metadata'            => 'metadata',
            'paid'                => true,
            'receiptEmail'        => $this->createMock(Email::class),
            'receiptNumber'       => 'xxxxxxx',
            'source'              => $mockCard,
            'statementDescriptor' => 'descriptor',
            'status'              => true,
            'captured'            => true,
            'livemode'            => false,
        ];

        $resource->setAmount($test['amount'])
            ->setCustomer($test['customer'])
            ->setReceiptEmail($test['receiptEmail'])
            ->setSource($test['source'])
            ->setStatementDescriptor($test['statementDescriptor']);

        $this::assertSame($test['amount'], $resource->getAmount());
        $this::assertSame($test['customer'], $resource->getCustomer());
        $this::assertSame($test['receiptEmail'], $resource->getReceiptEmail());
        // Hard coded result: equal to the ID set for $mockCard
        $this::assertSame('123', $resource->getSource());
        $this::assertSame($test['statementDescriptor'], $resource->getStatementDescriptor());

        // Populate the object
        $this->populateModel($resource, $test);

        $this::assertSame($test['id'], $resource->getId());
        $this::assertSame($test['balanceTransaction'], $resource->getBalanceTransaction());
        $this::assertSame($test['created'], $resource->getCreated());
        $this::assertSame($test['description'], $resource->getDescription());
        $this::assertSame($test['failureCode'], $resource->getFailureCode());
        $this::assertSame($test['failureMessage'], $resource->getFailureMessage());
        $this::assertSame($test['fraudDetails'], $resource->getFraudDetails());
        $this::assertSame($test['metadata'], $resource->getMetadata());
        $this::assertSame($test['paid'], $resource->getPaid());
        $this::assertSame($test['receiptNumber'], $resource->getReceiptNumber());
        $this::assertSame($test['status'], $resource->getStatus());
        $this::assertTrue($resource->isCaptured());
        $this::assertFalse($resource->isLivemode());
    }

    public function testToStripeCreateFullArray()
    {
        // This is not mockable as is a final class. Maybe in the future we will use Mockery, but for the moment it is good as is.
        $currency = new Currency('EUR');
        $resource = new StripeLocalCharge();

        $expected = [
            'amount'               => 1000,
            'currency'             => 'EUR',
            'capture'              => true,
            'description'          => 'the description',
            'metadata'             => 'metadata',
            'receipt_email'        => 'test@example.com',
            'customer'             => 'cus_idofcustomerisastring',
            'source'               => 'card_idofthecardisastring',
            'statement_descriptor' => 'descriptor',
        ];

        $mockMoney = $this->createMock(Money::class);
        $mockMoney->method('getBaseAmount')->willReturn($expected['amount']);
        $mockMoney->method('getCurrency')->willReturn($currency);

        $mockCard = $this->createMock(StripeLocalCard::class);
        $mockCard->method('getId')->willReturn($expected['source']);

        $mockCustomer = $this->createMock(StripeLocalCustomer::class);
        $mockCustomer->method('getId')->willReturn($expected['customer']);

        $mockEmail = $this->createMock(Email::class);
        $mockEmail->method('getEmail')->willReturn($expected['receipt_email']);

        $test = [
            'amount'              => $mockMoney,
            'description'         => $expected['description'],
            'metadata'            => $expected['metadata'],
            'receiptEmail'        => $mockEmail,
            'customer'            => $mockCustomer,
            'source'              => $mockCard,
            'statementDescriptor' => $expected['statement_descriptor'],
        ];

        // Populate the object
        $this->populateModel($resource, $test);
        $resource->setSource($test['source']);

        // Set as to capture
        $resource->capture();

        $this::assertSame($expected, $resource->toStripe('create'));

        // Formally wrong, but simpler... Test notCapture
        $expected['capture'] = false;

        // Populate the object
        $this->populateModel($resource, $test);
        $resource->setSource($test['source']);

        // Set as to capture
        $resource->notCapture();

        $this::assertSame($expected, $resource->toStripe('create'));
    }

    public function testToStripeThrowsAnExceptionIfAmountIsNotSet()
    {
        $resource = new StripeLocalCharge();

        $this->expectException(\InvalidArgumentException::class);
        $resource->toStripe('create');
    }
}
