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
 * Dispatched when a sku.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
class StripeWebhookSkuEventEvent extends AbstractStripeWebhookEventEvent
{
    /**
     * Occurs whenever an sku is created.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-sku.created
     */
    const CREATED = 'stripe.webhook.sku.created';

    /**
     * Occurs whenever an sku is deleted.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-sku.deleted
     */
    const DELETED = 'stripe.webhook.sku.deleted';

    /**
     * Occurs whenever an sku is updated.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-sku.updated
     */
    const UPDATED = 'stripe.webhook.sku.updated';
}
