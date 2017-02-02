<?php

/*
 * This file is part of the SerendipityHQ Stripe Bundle.
 *
 * Copyright (c) Adamo Crespi <hello@aerendir.me>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Event;

/**
 * Dispatched when a review.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
class StripeWebhookReviewEvent extends AbstractStripeWebhookEventEvent
{
    /**
     * Occurs whenever an review is opened.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-review.opened
     */
    const OPENED = 'stripe.webhook.review.opened';

    /**
     * Occurs whenever a review is closed.
     *
     * The review's `reason` field will indicate why the review was closed (e.g. `approved`, `refunded`, `refunded_as_fraud`, `disputed`).
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-review.closed
     */
    const CLOSED = 'stripe.webhook.review.closed';
}