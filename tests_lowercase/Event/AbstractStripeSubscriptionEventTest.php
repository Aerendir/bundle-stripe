<?php

namespace SerendipityHQ\Bundle\StripeBundle\Tests\Model;

use PHPUnit\Framework\TestCase;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeSubscriptionCreateEvent;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalSubscription;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;

/**
 * Tests the AbstractStripeSubscriptionEvent.
 */
class AbstractStripeSubscriptionEventTest extends TestCase
{
    public function testAbstractStripeSubscriptionEvent()
    {
        $mockCustomer = $this->createMock(StripeLocalCustomer::class);
        $mockSubscription = $this->createMock(StripeLocalSubscription::class);
        $mockSubscription->method('getPlan')->willReturn('plan');
        $mockSubscription->method('getCustomer')->willReturn($mockCustomer);
        $resource = new StripeSubscriptionCreateEvent($mockSubscription);

        $this::assertSame($mockSubscription, $resource->getLocalSubscription());
    }

    public function testAbstractStripeSubscriptionEventRequiresAnAmount()
    {
        $mockCustomer = $this->createMock(StripeLocalCustomer::class);
        $mockSubscription = $this->createMock(StripeLocalSubscription::class);
        $mockSubscription->method('getCustomer')->willReturn($mockCustomer);

        $this::expectException(\InvalidArgumentException::class);
        new StripeSubscriptionCreateEvent($mockSubscription);
    }
}
