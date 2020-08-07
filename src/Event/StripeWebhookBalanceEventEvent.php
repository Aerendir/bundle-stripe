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

/**
 * Dispatched when a balance.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
final class StripeWebhookBalanceEventEvent extends AbstractStripeWebhookEventEvent
{
    /**
     * Occurs whenever your Stripe balance has been updated (e.g. when a charge collected is available to be paid out).
     * By default, Stripe will automatically transfer any funds in your balance to your bank account on a daily basis.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-balance.available
     */
    const AVAILABLE = 'stripe.webhook.balance.available';
}
