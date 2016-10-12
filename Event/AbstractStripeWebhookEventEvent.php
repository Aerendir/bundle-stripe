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

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalWebhookEvent;
use Symfony\Component\EventDispatcher\Event;

/**
 * Abstract class to manage Charges.
 */
class AbstractStripeWebhookEventEvent extends Event
{
    /** @var StripeLocalWebhookEvent $webhookEvent */
    private $webhookEvent;

    /**
     * @param StripeLocalWebhookEvent $webhookEvent The local entity representing the \Stripe\Event
     */
    public function __construct(StripeLocalWebhookEvent $webhookEvent)
    {
        $this->webhookEvent = $webhookEvent;
    }

    /**
     * @return StripeLocalWebhookEvent
     */
    public function getWebhookEvent()
    {
        return $this->webhookEvent;
    }
}
