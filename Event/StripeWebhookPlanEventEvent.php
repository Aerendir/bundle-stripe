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
 * Dispatched when a plan.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
class StripeWebhookPlanEventEvent extends AbstractStripeWebhookEventEvent
{
    /**
     * Occurs whenever an plan is created.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-plan.created
     */
    const CREATED = 'stripe.webhook.plan.created';

    /**
     * Occurs whenever an plan is deleted.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-plan.deleted
     */
    const DELETED = 'stripe.webhook.plan.deleted';

    /**
     * Occurs whenever an plan is updated.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-plan.updated
     */
    const UPDATED = 'stripe.webhook.plan.updated';
}
