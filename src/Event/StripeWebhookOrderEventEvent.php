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
 * Dispatched when an order.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
final class StripeWebhookOrderEventEvent extends AbstractStripeWebhookEventEvent
{
    /**
     * Occurs whenever an order is created.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-order.created
     */
    const CREATED = 'stripe.webhook.order.created';

    /**
     * Occurs whenever payment is attempted on an order, and the payment fails.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-order.payment_failed
     */
    const PAYMENT_FAILED = 'stripe.webhook.order.payment_failed';

    /**
     * Occurs whenever payment is attempted on an order, and the payment succeeds.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-order.payment_succeeded
     */
    const PAYMENT_SUCCEEDED = 'stripe.webhook.order.payment_succeeded';

    /**
     * Occurs whenever an order is updated.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-order.updated
     */
    const UPDATED = 'stripe.webhook.order.updated';
}
