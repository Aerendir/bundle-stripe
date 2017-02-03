<?php

namespace SerendipityHQ\Bundle\StripeBundle\Tests\Model;

use PHPUnit\Framework\TestCase;
use SerendipityHQ\Bundle\StripeBundle\Event\StripePlanCreateEvent;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalPlan;

/**
 * Tests the AbstractStripePlanEvent.
 */
class AbstractStripePlanEventTest extends TestCase
{
    public function testAbstractStripePlanEvent()
    {
        $mockPlan = $this->createMock(StripeLocalPlan::class);
        $resource = new StripePlanCreateEvent($mockPlan);

        $this::assertSame($mockPlan, $resource->getLocalPlan());
    }
}
