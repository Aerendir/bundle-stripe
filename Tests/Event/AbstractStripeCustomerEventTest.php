<?php

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
        $resource = new StripeCustomerCreateEvent($mockCustomer);

        $this::assertSame($mockCustomer, $resource->getLocalCustomer());
    }
}
