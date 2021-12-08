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
 * Dispatched when a transfer.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
final class StripeWebhookTransferEventEvent extends AbstractStripeWebhookEventEvent
{
    /**
     * Occurs whenever a new transfer is created.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-transfer.created
     */
    public const CREATED = 'stripe.webhook.transfer.created';

    /**
     * Occurs whenever Stripe attempts to send a transfer and that transfer fails.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-transfer.failed
     */
    public const FAILED = 'stripe.webhook.transfer.failed';

    /**
     * Occurs whenever a sent transfer is expected to be available in the destination bank account.
     *
     * If the transfer failed, a transfer.failed webhook will additionally be sent at a later time.
     * Note to Connect users: this event is only created for transfers from your connected Stripe accounts to their bank
     * accounts, not for transfers to the connected accounts themselves.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-transfer.paid
     */
    public const PAID = 'stripe.webhook.transfer.paid';

    /**
     * Occurs whenever a transfer is reversed, including partial reversals.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-transfer.reversed
     */
    public const REVERSED = 'stripe.webhook.transfer.reversed';

    /**
     * Occurs whenever a transfer is updated.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-transfer.updated
     */
    public const UPDATED = 'stripe.webhook.transfer.updated';
}
