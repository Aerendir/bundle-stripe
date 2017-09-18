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
 * Dispatched when a transfer.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
class StripeWebhookTransferEventEvent extends AbstractStripeWebhookEventEvent
{
    /**
     * Occurs whenever a new transfer is created.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-transfer.created
     */
    const CREATED = 'stripe.webhook.transfer.created';

    /**
     * Occurs whenever Stripe attempts to send a transfer and that transfer fails.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-transfer.failed
     */
    const FAILED = 'stripe.webhook.transfer.failed';

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
    const PAID = 'stripe.webhook.transfer.paid';

    /**
     * Occurs whenever a transfer is reversed, including partial reversals.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-transfer.reversed
     */
    const REVERSED = 'stripe.webhook.transfer.reversed';

    /**
     * Occurs whenever a transfer is updated.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-transfer.updated
     */
    const UPDATED = 'stripe.webhook.transfer.updated';
}
