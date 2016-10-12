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

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;
use Symfony\Component\EventDispatcher\Event;

/**
 * Abstract class to manage Charges.
 */
class AbstractStripeWebhookEvent extends Event
{
    /** @var StripeLocalCharge $webhookEvent */
    private $webhookEvent;

    /**
     * @param \Stripe\Event $webhookEvent
     */
    public function __construct(\Stripe\Event $webhookEvent)
    {
        $this->webhookEvent = $webhookEvent;
    }

    /**
     * @return StripeLocalCharge
     */
    public function getWebhookEvent()
    {
        return $this->webhookEvent;
    }
}
