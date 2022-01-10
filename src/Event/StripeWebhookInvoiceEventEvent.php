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
 * Dispatched when an invoice.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
final class StripeWebhookInvoiceEventEvent extends AbstractStripeWebhookEventEvent
{
    /**
     * Occurs whenever a new invoice is created.
     *
     * If you are using webhooks, Stripe will wait one hour after they have all succeeded to attempt to pay the invoice;
     * the only exception here is on the first invoice, which gets created and paid immediately when you subscribe a
     * customer to a plan. If your webhooks do not all respond successfully, Stripe will continue retrying the webhooks
     * every hour and will not attempt to pay the invoice. After 3 days, Stripe will attempt to pay the invoice
     * regardless of whether or not your webhooks have succeeded.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-invoice.created
     * @see https://stripe.com/docs/webhooks
     * @see https://stripe.com/docs/webhooks#responding_to_a_webhook
     */
    public const CREATED = 'stripe.webhook.invoice.created';

    /**
     * Occurs whenever an invoice attempts to be paid, and the payment fails.
     *
     * This can occur either due to a declined payment, or because the customer has no active card. A particular case of
     * note is that if a customer with no active card reaches the end of its free trial, an invoice.payment_failed
     * notification will occur.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-invoice.payment_failed
     */
    public const PAYMENT_FAILED = 'stripe.webhook.invoice.payment_failed';

    /**
     * Occurs whenever an invoice attempts to be paid, and the payment succeeds.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-invoice.payment_succeeded
     */
    public const PAYMENT_SUCCEEDED = 'stripe.webhook.invoice.payment_succeeded';

    /**
     * Occurs whenever an invoice changes (for example, the amount could change).
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-invoice.updated
     */
    public const UPDATED = 'stripe.webhook.invoice.updated';
}
