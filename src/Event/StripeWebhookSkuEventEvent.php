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

/**
 * Dispatched when a sku.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
final class StripeWebhookSkuEventEvent extends AbstractStripeWebhookEventEvent
{
    /**
     * Occurs whenever an sku is created.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-sku.created
     */
    public const CREATED = 'stripe.webhook.sku.created';

    /**
     * Occurs whenever an sku is deleted.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-sku.deleted
     */
    public const DELETED = 'stripe.webhook.sku.deleted';

    /**
     * Occurs whenever an sku is updated.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-sku.updated
     */
    public const UPDATED = 'stripe.webhook.sku.updated';
}
