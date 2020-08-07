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
use SerendipityHQ\Bundle\StripeBundle\Event\StripePlanCreateEvent;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalPlan;

final class AbstractStripePlanEventTest extends TestCase
{
    public function testAbstractStripePlanEvent(): void
    {
        $mockPlan = $this->createMock(StripeLocalPlan::class);
        $resource = new StripePlanCreateEvent($mockPlan);

        self::assertSame($mockPlan, $resource->getLocalPlan());
    }
}
