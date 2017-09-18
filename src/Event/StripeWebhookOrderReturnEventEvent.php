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
 * Dispatched when an order_return.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
class StripeWebhookOrderReturnEventEvent extends AbstractStripeWebhookEventEvent
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
