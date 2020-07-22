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
        $resource  = new StripeWebhookChargeEventEvent($mockEvent);

        $this::assertSame($mockEvent, $resource->getLocalWebhookEvent());
    }
}
