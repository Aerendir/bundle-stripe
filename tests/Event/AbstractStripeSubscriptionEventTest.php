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

use PHPUnit\Framework\TestCase;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeSubscriptionCreateEvent;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalSubscription;

/**
 * Tests the AbstractStripeSubscriptionEvent.
 */
class AbstractStripeSubscriptionEventTest extends TestCase
{
    public function testAbstractStripeSubscriptionEvent()
    {
        $mockCustomer     = $this->createMock(StripeLocalCustomer::class);
        $mockSubscription = $this->createMock(StripeLocalSubscription::class);
        $mockSubscription->method('getPlan')->willReturn('plan');
        $mockSubscription->method('getCustomer')->willReturn($mockCustomer);
        $resource = new StripeSubscriptionCreateEvent($mockSubscription);

        $this::assertSame($mockSubscription, $resource->getLocalSubscription());
    }

    public function testAbstractStripeSubscriptionEventRequiresAnAmount()
    {
        $mockCustomer     = $this->createMock(StripeLocalCustomer::class);
        $mockSubscription = $this->createMock(StripeLocalSubscription::class);
        $mockSubscription->method('getCustomer')->willReturn($mockCustomer);

        $this::expectException(\InvalidArgumentException::class);
        new StripeSubscriptionCreateEvent($mockSubscription);
    }
}
