<?php

declare(strict_types=1);

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Abstract class to manage Stripe Events.
 */
abstract class AbstractStripeEvent extends Event
{
    /** @var array $stopReason */
    private $stopReason;

    public function getStopReason(): array
    {
        return $this->stopReason;
    }

    /**
     * @return AbstractStripeEvent
     */
    public function setStopReason(array $stopReason): self
    {
        $this->stopReason = $stopReason;

        return $this;
    }
}
