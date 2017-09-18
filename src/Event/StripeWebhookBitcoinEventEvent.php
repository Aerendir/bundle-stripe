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
 * Dispatched when a bitcoin.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
class StripeWebhookBitcoinEventEvent extends AbstractStripeWebhookEventEvent
{
    /**
     * Occurs whenever a receiver has been created.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-bitcoin.receiver.created
     */
    const RECEIVER_CREATED = 'stripe.webhook.receiver.created';

    /**
     * Occurs whenever a receiver is filled (that is, when it has received enough bitcoin to process a payment of the
     * same amount).
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-bitcoin.receiver.filled
     */
    const RECEIVER_FILLED = 'stripe.webhook.receiver.filled';

    /**
     * Occurs whenever a receiver is updated.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-bitcoin.receiver.updated
     */
    const RECEIVER_UPDATED = 'stripe.webhook.receiver.refund.updated';

    /**
     * Occurs whenever bitcoin is pushed to a receiver.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-bitcoin.receiver.transaction.created
     */
    const RECEIVER_TRANSACTION_CREATED = 'stripe.webhook.receiver.transaction.created';
}
