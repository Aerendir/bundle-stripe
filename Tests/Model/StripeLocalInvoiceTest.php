<?php

namespace SerendipityHQ\Bundle\StripeBundle\Tests\Model;

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalInvoice;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Bundle\StripeBundle\Tests\ModelTestCase;

/**
 * Tests the StripeLocalInvoice entity.
 */
class StripeLocalInvoiceTest extends ModelTestCase
{
    public function testStripeLocalInvoice()
    {
        $resource = new StripeLocalInvoice();

        $test = [
            'id' => 'this_is_the_id',
            'object' => 'invoice',
            'amountDue' => 0,
            'applicationFee' => 0,
            'attemptCount' => 0,
            'attemped' => null,
            'charge' => '',
            'closed' => true,
            'customer' => $this->createMock(StripeLocalCustomer::class),
            'date' => new \DateTime(),
            'description' => '',
            'discount' => '',
            'endingBalance' => 0,
            'forgiven' => false,
            'lines' => '',
            'livemode' => false,
            'metadata' => 'metadata',
            'nextPaymentAttempt' => new \DateTime(),
            'paid' => false,
            'periodEnd' => new \DateTime(),
            'periodStart' => new \DateTime(),
            'receiptNumber' => '',
            'startingBalance' => 0,
            'statementDescriptor' => '',
            'subscription' => '',
            'subscriptionProrationDate' => new \DateTime(),
            'subtotal' => 0,
            'tax' => 0,
            'taxPercent' => 0,
            'total' => 0,
            'webhooksDeliveredAt' => new \DateTime(),
        ];

        $resource->setCustomer($test['customer'])
            ->setApplicationFee($test['applicationFee'])
            ->setAmountDue($test['amountDue'])
            ->setCharge($test['charge']);

        $this::assertSame($test['customer'], $resource->getCustomer());
        $this::assertSame($test['charge'], $resource->getCharge());

        // Populate the object
        $this->populateModel($resource, $test);

        $this::assertSame($test['id'], $resource->getId());
        $this::assertSame($test['object'], $resource->getObject());
        $this::assertSame($test['amountDue'], $resource->getAmountDue());
        $this::assertSame($test['applicationFee'], $resource->getApplicationFee());
        $this::assertSame($test['attemptCount'], $resource->getAttemptCount());
        $this::assertSame($test['attemped'], $resource->isAttempted());
        $this::assertSame($test['charge'], $resource->getCharge());
        $this::assertSame($test['closed'], $resource->isClosed());
        $this::assertSame($test['currency'], $resource->getCurrency());
        $this::assertSame($test['customer'], $resource->getCustomer());
        $this::assertSame($test['date'], $resource->getDate());
        $this::assertSame($test['description'], $resource->getDescription());
        $this::assertSame($test['discount'], $resource->getDiscount());
        $this::assertSame($test['endingBalance'], $resource->getEndingBalance());
        $this::assertSame($test['forgiven'], $resource->isForgiven());
        $this::assertSame($test['lines'], $resource->getLines());
        $this::assertSame($test['livemode'], $resource->isLivemode());
        $this::assertSame($test['metadata'], $resource->getMetadata());
        $this::assertSame($test['nextPaymentAttempt'], $resource->getNextPaymentAttempt());
        $this::assertSame($test['paid'], $resource->isPaid());
        $this::assertSame($test['periodEnd'], $resource->getPeriodEnd());
        $this::assertSame($test['periodStart'], $resource->getPeriodStart());
        $this::assertSame($test['receiptNumber'], $resource->getReceiptNumber());
        $this::assertSame($test['startingBalance'], $resource->getStartingBalance());
        $this::assertSame($test['statementDescriptor'], $resource->getStatementDescriptor());
        $this::assertSame($test['subtotal'], $resource->getSubtotal());
        $this::assertSame($test['tax'], $resource->getTax());
        $this::assertSame($test['taxPercent'], $resource->getTaxPercent());
        $this::assertSame($test['total'], $resource->getTotal());
        $this::assertSame($test['webhooksDeliveredAt'], $resource->getWebhooksDeliveredAt());
    }

    public function testToStripeCreateFullArray()
    {
        $resource = new StripeLocalInvoice();

        $now = new \DateTime();

        $expected = [
            'customer' => 'cus_idofcustomerisastring',
            'application_fee' => 0,
            'metadata' => 'metadata',
        ];

        $mockCustomer = $this->createMock(StripeLocalCustomer::class);
        $mockCustomer->method('getId')->willReturn($expected['customer']);

        $test = [
            'customer' => $mockCustomer,
            'applicationFee' => 0,
            'metadata' => 'metadata',
        ];

        // Populate the object
        $this->populateModel($resource, $test);

        $this::assertSame($expected, $resource->toStripe('create'));
    }

    public function testToStripeThrowsAnExceptionIfAmountIsNotSet()
    {
        $resource = new StripeLocalInvoice();

        $this->expectException(\InvalidArgumentException::class);
        $resource->toStripe('create');
    }
}
