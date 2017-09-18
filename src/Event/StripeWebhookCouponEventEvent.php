<?php

/*
 * This file is part of the SHQStripeBundle.
 *
 * Copyright Adamo Aerendir Crespi 2016-2017.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    Adamo Aerendir Crespi <hello@aerendir.me>
 * @copyright Copyright (C) 2016 - 2017 Aerendir. All rights reserved.
 * @license   MIT License.
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
