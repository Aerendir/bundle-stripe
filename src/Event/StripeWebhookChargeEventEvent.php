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
 * Dispatched when a charge.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
final class StripeWebhookChargeEventEvent extends AbstractStripeWebhookEventEvent
{
    /**
     * Occurs whenever a previously uncaptured charge is captured.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-charge.captured
     */
    public const CAPTURED = 'stripe.webhook.charge.captured';

    /**
     * Occurs whenever a failed charge attempt occurs.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-charge.failed
     */
    public const FAILED = 'stripe.webhook.charge.failed';

    /**
     * Occurs whenever a pending charge is created.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-charge.pending
     */
    public const PENDING = 'stripe.webhook.charge.pending';

    /**
     * Occurs whenever a charge is refunded, including partial refunds.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-charge.refunded
     */
    public const REFUNDED = 'stripe.webhook.charge.refunded';

    /**
     * Occurs whenever a new charge is created and is successful.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-charge.succeeded
     */
    public const SUCCEEDED = 'stripe.webhook.charge.succeeded';

    /**
     * Occurs whenever a charge description or metadata is updated.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-charge.updated
     */
    public const UPDATED = 'stripe.webhook.charge.updated';

    /**
     * Occurs when the dispute is closed and the dispute status changes to charge_refunded, lost, warning_closed, or
     * won.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-charge.dispute.closed
     */
    public const DISPUTE_CLOSED = 'stripe.webhook.charge.dispute.closed';

    /**
     * Occurs whenever a customer disputes a charge with their bank (chargeback).
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-charge.dispute.created
     */
    public const DISPUTE_CREATED = 'stripe.webhook.charge.dispute.created';

    /**
     * Occurs when funds are reinstated to your account after a dispute is won.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-charge.dispute.funds_reinstated
     */
    public const DISPUTE_FUNDS_REINSTATED = 'stripe.webhook.charge.dispute.funds_reinstated';

    /**
     * Occurs when funds are removed from your account due to a dispute.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-charge.dispute.funds_withdrawn
     */
    public const DISPUTE_FUNDS_WITHDRAWN = 'stripe.webhook.charge.dispute.funds_withdrawn';

    /**
     * Occurs when the dispute is updated (usually with evidence).
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-charge.dispute.updated
     */
    public const DISPUTE_UPDATED = 'stripe.webhook.charge.dispute.updated';
}
