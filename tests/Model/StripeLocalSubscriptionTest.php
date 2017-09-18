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

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalSubscription;
use SerendipityHQ\Bundle\StripeBundle\Tests\ModelTestCase;

/**
 * Tests the StripeLocalSubscription entity.
 */
class StripeLocalSubscriptionTest extends ModelTestCase
{
    public function testStripeLocalSubscription()
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

        $this::assertSame($test['customer'], $resource->getCustomer());
        $this::assertSame($test['plan'], $resource->getPlan());

        // Populate the object
        $this->populateModel($resource, $test);

        $this::assertSame($test['id'], $resource->getId());
        $this::assertSame($test['applicationFeePercent'], $resource->getApplicationFeePercent());
        $this::assertSame($test['cancelAtPeriodEnd'], $resource->isCancelAtPeriodEnd());
        $this::assertSame($test['canceledAt'], $resource->getCanceledAt());
        $this::assertSame($test['created'], $resource->getCreated());
        $this::assertSame($test['currentPeriodEnd'], $resource->getCurrentPeriodEnd());
        $this::assertSame($test['currentPeriodStart'], $resource->getCurrentPeriodStart());
        $this::assertSame($test['discount'], $resource->getDiscount());
        $this::assertSame($test['endedAt'], $resource->getEndedAt());
        $this::assertFalse($resource->isLivemode());
        $this::assertSame($test['metadata'], $resource->getMetadata());
        $this::assertSame($test['quantity'], $resource->getQuantity());
        $this::assertSame($test['start'], $resource->getStart());
        $this::assertSame($test['status'], $resource->getStatus());
        $this::assertSame($test['trialEnd'], $resource->getTrialEnd());
        $this::assertSame($test['trialStart'], $resource->getTrialStart());
    }

    public function testToStripeCreateFullArray()
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

        $this::assertSame($expected, $resource->toStripe('create'));
    }

    public function testToStripeThrowsAnExceptionIfAmountIsNotSet()
    {
        $resource = new StripeLocalSubscription();

        $this->expectException(\InvalidArgumentException::class);
        $resource->toStripe('create');
    }
}
