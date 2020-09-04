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
use SerendipityHQ\Bundle\StripeBundle\Event\StripeChargeCreateEvent;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Component\ValueObjects\Money\Money;

final class AbstractStripeChargeEventTest extends TestCase
{
    public function testAbstractStripeChargeEvent(): void
    {
        $mockCustomer = $this->createMock(StripeLocalCustomer::class);
        $mockAmount   = $this->createMock(Money::class);
        $mockCharge   = $this->createMock(StripeLocalCharge::class);
        $mockCharge->method('getAmount')->willReturn($mockAmount);
        $mockCharge->method('getCustomer')->willReturn($mockCustomer);
        $resource = new StripeChargeCreateEvent($mockCharge);

        self::assertSame($mockCharge, $resource->getLocalCharge());
    }
}
