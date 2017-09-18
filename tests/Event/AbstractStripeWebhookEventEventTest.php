<?php

namespace SerendipityHQ\Bundle\StripeBundle\Tests\Model;

use PHPUnit\Framework\TestCase;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookChargeEventEvent;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalWebhookEvent;

/**
 * Tests the AbstractStripeWebhookEventEvent.
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
class AbstractStripeWebhookEventEventTest extends TestCase
{
    public function testAbstractStripeWebhookEventEvent()
    {
        $mockEvent = $this->createMock(StripeLocalWebhookEvent::class);
        $resource = new StripeWebhookChargeEventEvent($mockEvent);

        $this::assertSame($mockEvent, $resource->getLocalWebhookEvent());
    }
}
