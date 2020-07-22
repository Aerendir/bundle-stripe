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
 * Dispatched when a coupon.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
class StripeWebhookCouponEventEvent extends AbstractStripeWebhookEventEvent
{
    /**
     * Occurs whenever a coupon is created.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-coupon.created
     */
    const CREATED = 'stripe.webhook.coupon.created';

    /**
     * Occurs whenever a coupon is deleted.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-coupon.deleted
     */
    const DELETED = 'stripe.webhook.coupon.deleted';

    /**
     * Occurs whenever a coupon is updated.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-coupon.updated
     */
    const UPDATED = 'stripe.webhook.coupon.updated';
}
