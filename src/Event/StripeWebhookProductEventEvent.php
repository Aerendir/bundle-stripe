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
 * Dispatched when a product.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
final class StripeWebhookProductEventEvent extends AbstractStripeWebhookEventEvent
{
    /**
     * Occurs whenever an product is created.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-product.created
     */
    const CREATED = 'stripe.webhook.product.created';

    /**
     * Occurs whenever an product is deleted.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-product.deleted
     */
    const DELETED = 'stripe.webhook.product.deleted';

    /**
     * Occurs whenever an product is updated.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-product.updated
     */
    const UPDATED = 'stripe.webhook.product.updated';
}
