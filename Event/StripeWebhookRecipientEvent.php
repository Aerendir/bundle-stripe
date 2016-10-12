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
 * Dispatched when a recipient.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
class StripeWebhookRecipientEvent extends AbstractStripeWebhookEvent
{
    /**
     * Occurs whenever an recipient is created.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-recipient.created
     */
    const CREATED = 'stripe.webhook.recipient.created';

    /**
     * Occurs whenever an recipient is deleted.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-recipient.deleted
     */
    const DELETED = 'stripe.webhook.recipient.deleted';

    /**
     * Occurs whenever an recipient is updated.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-recipient.updated
     */
    const UPDATED = 'stripe.webhook.recipient.updated';
}
