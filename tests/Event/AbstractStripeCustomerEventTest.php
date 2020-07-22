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
use SerendipityHQ\Bundle\StripeBundle\Event\StripeCustomerCreateEvent;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;

/**
 * Tests the AbstractStripeCustomerEvent.
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
class AbstractStripeCustomerEventTest extends TestCase
{
    public function testAbstractStripeCustomerEvent()
    {
        $mockCustomer = $this->createMock(StripeLocalCustomer::class);
        $resource     = new StripeCustomerCreateEvent($mockCustomer);

        $this::assertSame($mockCustomer, $resource->getLocalCustomer());
    }
}
