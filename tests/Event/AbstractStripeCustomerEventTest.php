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
use SerendipityHQ\Bundle\StripeBundle\Event\StripeCustomerCreateEvent;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;

final class AbstractStripeCustomerEventTest extends TestCase
{
    public function testAbstractStripeCustomerEvent(): void
    {
        $mockCustomer = $this->createMock(StripeLocalCustomer::class);
        $resource     = new StripeCustomerCreateEvent($mockCustomer);

        self::assertSame($mockCustomer, $resource->getLocalCustomer());
    }
}
