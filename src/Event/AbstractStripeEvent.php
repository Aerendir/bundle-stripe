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
    public function getStopReason(): array
    {
        return $this->stopReason;
    }

    /**
     * @param array $stopReason
     *
     * @return AbstractStripeEvent
     */
    public function setStopReason(array $stopReason): self
    {
        $this->stopReason = $stopReason;

        return $this;
    }
}
