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
 * Dispatched when an order_return.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
final class StripeWebhookOrderReturnEventEvent extends AbstractStripeWebhookEventEvent
{
    /**
     * Occurs whenever an order return is created.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-order_return.created
     */
    const CREATED = 'stripe.webhook.order_return.created';
}
