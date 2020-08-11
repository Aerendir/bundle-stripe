<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Event;

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalPlan;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Abstract class to manage Plans.
 */
abstract class AbstractStripePlanEvent extends Event
{
    /** @var \SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalPLan $localPlan */
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
    public function getLocalPlan(): \SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalPlan
    {
        return $this->localPlan;
    }
}
