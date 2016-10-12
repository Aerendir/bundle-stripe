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

/**
 * Dispatched when a ping.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
class StripeWebhookPingEvent extends AbstractStripeWebhookEvent
{
    /**
     * May be sent by Stripe at any time to see if a provided webhook URL is working.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-ping
     */
    const PING = 'stripe.webhook.ping';
}
