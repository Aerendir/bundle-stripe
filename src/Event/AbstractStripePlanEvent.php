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

namespace SerendipityHQ\Bundle\StripeBundle\Event;

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalPLan;
use Symfony\Component\EventDispatcher\Event;

/**
 * Abstract class to manage Plans.
 */
abstract class AbstractStripePlanEvent extends Event
{
    /** @var StripeLocalPlan $localPlan */
    private $localPlan;

    /**
     * @param StripeLocalPlan $plan
     */
    public function __construct(StripeLocalPlan $plan)
    {
        $this->localPlan = $plan;
    }

    /**
     * @return StripeLocalPlan
     */
    public function getLocalPlan()
    {
        return $this->localPlan;
    }
}
