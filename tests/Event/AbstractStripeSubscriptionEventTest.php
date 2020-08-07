<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Tests\Event;

use PHPUnit\Framework\TestCase;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeSubscriptionCreateEvent;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalSubscription;

final class AbstractStripeSubscriptionEventTest extends TestCase
{
    public function testAbstractStripeSubscriptionEvent(): void
    {
        $mockCustomer     = $this->createMock(StripeLocalCustomer::class);
        $mockSubscription = $this->createMock(StripeLocalSubscription::class);
        $mockSubscription->method('getPlan')->willReturn('plan');
        $mockSubscription->method('getCustomer')->willReturn($mockCustomer);
        $resource = new StripeSubscriptionCreateEvent($mockSubscription);

        self::assertSame($mockSubscription, $resource->getLocalSubscription());
    }

    public function testAbstractStripeSubscriptionEventRequiresAnAmount(): void
    {
        $mockCustomer     = $this->createMock(StripeLocalCustomer::class);
        $mockSubscription = $this->createMock(StripeLocalSubscription::class);
        $mockSubscription->method('getCustomer')->willReturn($mockCustomer);

        self::expectException(\InvalidArgumentException::class);
        new StripeSubscriptionCreateEvent($mockSubscription);
    }
}
