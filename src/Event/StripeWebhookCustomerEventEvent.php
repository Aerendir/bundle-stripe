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
 * Dispatched when a customer.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
final class StripeWebhookCustomerEventEvent extends AbstractStripeWebhookEventEvent
{
    /**
     * Occurs whenever a customer is created.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.created
     */
    public const CREATED = 'stripe.webhook.customer.created';

    /**
     * Occurs whenever a customer is deleted.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.deleted
     */
    public const DELETED = 'stripe.webhook.customer.deleted';

    /**
     * Occurs whenever any property of a customer changes.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.updated
     */
    public const UPDATED = 'stripe.webhook.customer.updated';

    /**
     * Occurs whenever a coupon is attached to a customer.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.discount.created
     */
    public const DISCOUNT_CREATED = 'stripe.webhook.customer.discount.created';

    /**
     * Occurs whenever a customer's discount is removed.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.discount.deleted
     */
    public const DISCOUNT_DELETED = 'stripe.webhook.customer.discount.deleted';

    /**
     * Occurs whenever a customer is switched from one coupon to another.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.discount.udated
     */
    public const DISCOUNT_UPDATED = 'stripe.webhook.customer.discount.udated';

    /**
     * Occurs whenever a new source is created for the customer.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.source.created
     */
    public const SOURCE_CREATED = 'stripe.webhook.customer.source.created';

    /**
     * Occurs whenever a source is removed from a customer.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.source.deleted
     */
    public const SOURCE_DELETED = 'stripe.webhook.customer.source.deleted';

    /**
     * Occurs whenever a source's details are changed.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.source.udated
     */
    public const SOURCE_UPDATED = 'stripe.webhook.customer.source.udated';
}
