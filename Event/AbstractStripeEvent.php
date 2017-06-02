<?php

/*
 * This file is part of the SerendipityHQ Stripe Bundle.
 *
 * Copyright (c) Adamo Crespi <hello@aerendir.me>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Abstract class to manage Stripe Events.
 */
abstract class AbstractStripeEvent extends Event
{
    /** @var array $stopReason */
    private $stopReason;

    /**
     * @return array
     */
    public function getStopReason()
    {
        return $this->stopReason;
    }

    /**
     * @param array $stopReason
     *
     * @return AbstractStripeEvent
     */
    public function setStopReason(array $stopReason)
    {
        $this->stopReason = $stopReason;

        return $this;
    }
}
