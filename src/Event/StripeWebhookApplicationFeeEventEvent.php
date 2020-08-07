<?php

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
 * Dispatched when an application_fee.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
final class StripeWebhookApplicationFeeEventEvent extends AbstractStripeWebhookEventEvent
{
    /**
     * Occurs whenever an application fee is created on a charge.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-application_fee.created
     */
    const CREATED = 'stripe.webhook.application_fee.created';

    /**
     * Occurs whenever an application fee is refunded, whether from refunding a charge or from refunding the application
     * fee directly, including partial refunds.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-application_fee.refunded
     * @see https://stripe.com/docs/api#refund_application_fee
     */
    const REFUNDED = 'stripe.webhook.application_fee.refunded';

    /**
     * Occurs whenever an application fee refund is updated.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-application_fee.refund.updated
     */
    const REFUND_UPDATED = 'stripe.webhook.application_fee.refund.updated';
}
