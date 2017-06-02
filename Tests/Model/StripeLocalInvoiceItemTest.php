<?php

namespace SerendipityHQ\Bundle\StripeBundle\Tests\Model;

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalInvoiceItem;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Bundle\StripeBundle\Tests\ModelTestCase;
use SerendipityHQ\Component\ValueObjects\Money\Money;
use SerendipityHQ\Component\ValueObjects\Currency\Currency;

/**
 * Tests the StripeLocalInvoiceItem entity.
 */
class StripeLocalInvoiceItemTest extends ModelTestCase
{
    public function testStripeLocalInvoiceItem()
    {
        $amountExpected = ['amount' => 999, 'currency' => 'eur'];

        $mockCurrency = $this->createMock(Currency::class);
        $mockCurrency->method('getCurrencyCode')->willReturn($amountExpected['currency']);

        $mockMoney = $this->createMock(Money::class);
        $mockMoney->method('getAmount')->willReturn($amountExpected['amount']);
        $mockMoney->method('getCurrency')->willReturn($mockCurrency);

        $resource = new StripeLocalInvoiceItem();

        $test = [
            'id' => 'this_is_the_id',
            'object' => 'line_item',
            'amount' => $mockMoney,
            'currency' => '',
            'customer' => $this->createMock(StripeLocalCustomer::class),
            'date' => new \DateTime(),
            'description' => '',
            'discountable' => false,
            'invoice' => '',
            'livemode' => false,
            'metadata' => 'metadata',
            'period' => '',
            'plan' => '',
            'proration' => false,
            'quantity' => 0,
            'subscription' => '',
            'subscriptionItem' => '',
        ];

        $resource->setCustomer($test['customer'])
            ->setAmount($test['amount']);

        $this::assertSame($test['customer'], $resource->getCustomer());

        // Populate the object
        $this->populateModel($resource, $test);

        $this::assertSame($test['id'], $resource->getId());
        $this::assertSame($test['object'], $resource->getObject());
        $this::assertSame($test['currency'], $resource->getCurrency());
        $this::assertSame($test['date'], $resource->getDate());
        $this::assertSame($test['description'], $resource->getDescription());
        $this::assertSame($test['discountable'], $resource->isDiscountable());
        $this::assertSame($test['invoice'], $resource->getInvoice());
        $this::assertSame($test['livemode'], $resource->isLiveMode());
        $this::assertSame($test['metadata'], $resource->getMetadata());
        $this::assertSame($test['period'], $resource->getPeriod());
        $this::assertSame($test['plan'], $resource->getPlan());
        $this::assertSame($test['proration'], $resource->getProration());
        $this::assertSame($test['quantity'], $resource->getQuantity());
        $this::assertSame($test['subscription'], $resource->getSubscription());
        $this::assertSame($test['subscriptionItem'], $resource->getSubscriptionItem());
    }

    public function testToStripeCreateFullArray()
    {
        $amountExpected = ['amount' => 999, 'currency' => 'eur'];

        $mockCurrency = $this->createMock(Currency::class);
        $mockCurrency->method('getCurrencyCode')->willReturn($amountExpected['currency']);

        $mockMoney = $this->createMock(Money::class);
        $mockMoney->method('getAmount')->willReturn($amountExpected['amount']);
        $mockMoney->method('getCurrency')->willReturn($mockCurrency);

        $resource = new StripeLocalInvoiceItem();

        $expected = [
            'amount' => $amountExpected['amount'],
            'currency' => $amountExpected['currency'],
            'customer' => 'cus_idofcustomerisastring',
            'metadata' => 'metadata',
        ];

        $mockCustomer = $this->createMock(StripeLocalCustomer::class);
        $mockCustomer->method('getId')->willReturn($expected['customer']);

        $test = [
            'customer' => $mockCustomer,
            'amount' => $mockMoney,
            'metadata' => 'metadata',
        ];

        // Populate the object
        $this->populateModel($resource, $test);

        $this::assertSame($expected, $resource->toStripe('create'));
    }

    public function testToStripeThrowsAnExceptionIfAmountIsNotSet()
    {
        $resource = new StripeLocalInvoiceItem();

        $this->expectException(\InvalidArgumentException::class);
        $resource->toStripe('create');
    }
}
