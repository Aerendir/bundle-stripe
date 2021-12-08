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
 * Dispatched when a bitcoin.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
final class StripeWebhookBitcoinEventEvent extends AbstractStripeWebhookEventEvent
{
    /**
     * Occurs whenever a receiver has been created.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-bitcoin.receiver.created
     */
    public const RECEIVER_CREATED = 'stripe.webhook.receiver.created';

    /**
     * Occurs whenever a receiver is filled (that is, when it has received enough bitcoin to process a payment of the
     * same amount).
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-bitcoin.receiver.filled
     */
    public const RECEIVER_FILLED = 'stripe.webhook.receiver.filled';

    /**
     * Occurs whenever a receiver is updated.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-bitcoin.receiver.updated
     */
    public const RECEIVER_UPDATED = 'stripe.webhook.receiver.refund.updated';

    /**
     * Occurs whenever bitcoin is pushed to a receiver.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-bitcoin.receiver.transaction.created
     */
    public const RECEIVER_TRANSACTION_CREATED = 'stripe.webhook.receiver.transaction.created';
}
