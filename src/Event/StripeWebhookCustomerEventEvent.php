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
 * Dispatched when a customer.* event has been received by the webhook endpoint.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
class StripeWebhookCustomerEventEvent extends AbstractStripeWebhookEventEvent
{
    /**
     * Occurs whenever a customer is created.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.created
     */
    const CREATED = 'stripe.webhook.customer.created';

    /**
     * Occurs whenever a customer is deleted.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.deleted
     */
    const DELETED = 'stripe.webhook.customer.deleted';

    /**
     * Occurs whenever any property of a customer changes.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.updated
     */
    const UPDATED = 'stripe.webhook.customer.updated';

    /**
     * Occurs whenever a coupon is attached to a customer.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.discount.created
     */
    const DISCOUNT_CREATED = 'stripe.webhook.customer.discount.created';

    /**
     * Occurs whenever a customer's discount is removed.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.discount.deleted
     */
    const DISCOUNT_DELETED = 'stripe.webhook.customer.discount.deleted';

    /**
     * Occurs whenever a customer is switched from one coupon to another.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.discount.udated
     */
    const DISCOUNT_UPDATED = 'stripe.webhook.customer.discount.udated';

    /**
     * Occurs whenever a new source is created for the customer.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.source.created
     */
    const SOURCE_CREATED = 'stripe.webhook.customer.source.created';

    /**
     * Occurs whenever a source is removed from a customer.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.source.deleted
     */
    const SOURCE_DELETED = 'stripe.webhook.customer.source.deleted';

    /**
     * Occurs whenever a source's details are changed.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.source.udated
     */
    const SOURCE_UPDATED = 'stripe.webhook.customer.source.udated';

    /**
     * Occurs whenever a customer with no subscription is signed up for a plan.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.subscription.created
     */
    const SUBSCRIPTION_CREATED = 'stripe.webhook.customer.subscription.created';

    /**
     * Occurs whenever a customer ends their subscription.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.subscription.deleted
     */
    const SUBSCRIPTION_DELETED = 'stripe.webhook.customer.subscription.deleted';

    /**
     * Occurs three days before the trial period of a subscription is scheduled to end.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.subscription.trial_will_end
     */
    const SUBSCRIPTION_TRIAL_WILL_END = 'stripe.webhook.customer.subscription.trial_will_end';

    /**
     * Occurs whenever a subscription changes. Examples would include switching from one plan to another, or switching
     * status from trial to active.
     *
     * @var string
     *
     * @see https://stripe.com/docs/api#event_types-customer.subscription.udated
     */
    const SUBSCRIPTION_UPDATED = 'stripe.webhook.customer.subscription.udated';
}
