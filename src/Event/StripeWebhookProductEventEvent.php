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
 * Dispatched when a product.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
class StripeWebhookProductEventEvent extends AbstractStripeWebhookEventEvent
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
