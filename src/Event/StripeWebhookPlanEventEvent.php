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
