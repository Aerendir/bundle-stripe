<?php

declare(strict_types=1);

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
final class StripeLocalChargeTest extends ModelTestCase
{
    public function testStripeLocalCharge(): void
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
            'fraudDetails'        => ['details about fraud'],
            'metadata'            => ['this_is_the_key' => 'this is the value'],
            'paid'                => true,
            'receiptEmail'        => $this->createMock(Email::class),
            'receiptNumber'       => 'xxxxxxx',
            'source'              => $mockCard,
            'statementDescriptor' => 'descriptor',
            'status'              => 'pending',
            'captured'            => true,
            'livemode'            => false,
        ];

        $resource->setAmount($test['amount'])
            ->setCustomer($test['customer'])
            /* @phan-suppress-next-line PhanTypeMismatchArgumentReal */
            ->setReceiptEmail($test['receiptEmail'])
            ->setSource($test['source'])
            ->setStatementDescriptor($test['statementDescriptor']);

        self::assertSame($test['amount'], $resource->getAmount());
        self::assertSame($test['customer'], $resource->getCustomer());
        self::assertSame($test['receiptEmail'], $resource->getReceiptEmail());
        self::assertSame($test['source'], $resource->getSource());
        self::assertSame($test['statementDescriptor'], $resource->getStatementDescriptor());

        // Populate the object
        $this->populateModel($resource, $test);

        self::assertSame($test['id'], $resource->getId());
        self::assertSame($test['balanceTransaction'], $resource->getBalanceTransaction());
        self::assertSame($test['created'], $resource->getCreated());
        self::assertSame($test['description'], $resource->getDescription());
        self::assertSame($test['failureCode'], $resource->getFailureCode());
        self::assertSame($test['failureMessage'], $resource->getFailureMessage());
        self::assertSame($test['fraudDetails'], $resource->getFraudDetails());
        self::assertSame($test['metadata'], $resource->getMetadata());
        self::assertTrue($resource->getPaid());
        self::assertSame($test['receiptNumber'], $resource->getReceiptNumber());
        self::assertSame($test['status'], $resource->getStatus());
        self::assertTrue($resource->isCaptured());
        self::assertFalse($resource->isLivemode());
    }

    public function testToStripeCreateFullArray(): void
    {
        // This is not mockable as is a final class. Maybe in the future we will use Mockery, but for the moment it is good as is.
        $currency = new Currency('EUR');
        $resource = new StripeLocalCharge();

        $expected = [
            'amount'               => '1000',
            'currency'             => 'EUR',
            'capture'              => true,
            'description'          => 'the description',
            'metadata'             => ['this_is_the_key' => 'this is the value'],
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

        self::assertSame($expected, $resource->toStripe('create'));

        // Formally wrong, but simpler... Test notCapture
        $expected['capture'] = false;

        // Populate the object
        $this->populateModel($resource, $test);
        $resource->setSource($test['source']);

        // Set as to capture
        $resource->notCapture();

        self::assertSame($expected, $resource->toStripe('create'));
    }

    public function testToStripeThrowsAnExceptionIfAmountIsNotSet(): void
    {
        $resource = new StripeLocalCharge();

        $this->expectException(\InvalidArgumentException::class);
        $resource->toStripe('create');
    }
}
