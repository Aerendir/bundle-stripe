<?php

/*
 * This file is part of the SHQStripeBundle.
 *
 * Copyright Adamo Aerendir Crespi 2016-2017.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    Adamo Aerendir Crespi <hello@aerendir.me>
 * @copyright Copyright (C) 2016 - 2017 Aerendir. All rights reserved.
 * @license   MIT License.
 */

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
