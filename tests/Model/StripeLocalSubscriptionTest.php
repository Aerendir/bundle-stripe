<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Tests\Model;

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalSubscription;
use SerendipityHQ\Bundle\StripeBundle\Tests\ModelTestCase;

/**
 * Tests the StripeLocalSubscription entity.
 */
final class StripeLocalSubscriptionTest extends ModelTestCase
{
    public function testStripeLocalSubscription(): void
    {
        $resource = new StripeLocalSubscription();

        $test = [
            'id'                    => 'this_is_the_id',
            'customer'              => $this->createMock(StripeLocalCustomer::class),
            'applicationFeePercent' => 0,
            'cancelAtPeriodEnd'     => true,
            'canceledAt'            => new \DateTime(),
            'created'               => new \DateTime(),
            'currentPeriodEnd'      => new \DateTime(),
            'currentPeriodStart'    => new \DateTime(),
            'discount'              => '',
            'endedAt'               => new \DateTime(),
            'livemode'              => false,
            'metadata'              => 'metadata',
            'plan'                  => 'agency',
            'quantity'              => 1,
            'start'                 => new \DateTime(),
            'status'                => 'status',
            'taxPercent'            => 0,
            'trialEnd'              => new \DateTime(),
            'trialStart'            => new \DateTime(),
        ];

        $resource->setCustomer($test['customer'])
            ->setApplicationFeePercent($test['applicationFeePercent'])
            ->setQuantity($test['quantity'])
            ->setPlan($test['plan']);

        self::assertSame($test['customer'], $resource->getCustomer());
        self::assertSame($test['plan'], $resource->getPlan());

        // Populate the object
        $this->populateModel($resource, $test);

        self::assertSame($test['id'], $resource->getId());
        self::assertSame($test['applicationFeePercent'], $resource->getApplicationFeePercent());
        self::assertSame($test['cancelAtPeriodEnd'], $resource->isCancelAtPeriodEnd());
        self::assertSame($test['canceledAt'], $resource->getCanceledAt());
        self::assertSame($test['created'], $resource->getCreated());
        self::assertSame($test['currentPeriodEnd'], $resource->getCurrentPeriodEnd());
        self::assertSame($test['currentPeriodStart'], $resource->getCurrentPeriodStart());
        self::assertSame($test['discount'], $resource->getDiscount());
        self::assertSame($test['endedAt'], $resource->getEndedAt());
        self::assertFalse($resource->isLivemode());
        self::assertSame($test['metadata'], $resource->getMetadata());
        self::assertSame($test['quantity'], $resource->getQuantity());
        self::assertSame($test['start'], $resource->getStart());
        self::assertSame($test['status'], $resource->getStatus());
        self::assertSame($test['trialEnd'], $resource->getTrialEnd());
        self::assertSame($test['trialStart'], $resource->getTrialStart());
    }

    public function testToStripeCreateFullArray(): void
    {
        $resource = new StripeLocalSubscription();

        $now = new \DateTime();

        $expected = [
            'customer'                => 'cus_idofcustomerisastring',
            'application_fee_percent' => 0,
            'metadata'                => 'metadata',
            'plan'                    => 'plan',
            'quantity'                => 1,
            'tax_percent'             => 0,
            'trial_end'               => $now->add(new \DateInterval('P1D')),
            'trial_period_days'       => 1,
        ];

        $mockCustomer = $this->createMock(StripeLocalCustomer::class);
        $mockCustomer->method('getId')->willReturn($expected['customer']);

        $test = [
            'customer'              => $mockCustomer,
            'applicationFeePercent' => 0,
            'metadata'              => 'metadata',
            'plan'                  => $expected['plan'],
            'quantity'              => $expected['quantity'],
            'taxPercent'            => 0,
            'trialEnd'              => $now,
            'trialStart'            => $now,
            'source'                => 'source',
        ];

        // Populate the object
        $this->populateModel($resource, $test);

        $resource->setSource($test['source']);

        self::assertSame($expected, $resource->toStripe('create'));
    }

    public function testToStripeThrowsAnExceptionIfAmountIsNotSet(): void
    {
        $resource = new StripeLocalSubscription();

        $this->expectException(\InvalidArgumentException::class);
        $resource->toStripe('create');
    }
}
