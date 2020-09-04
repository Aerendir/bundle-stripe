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

final class StripeSubscriptionCancelEvent extends AbstractStripeSubscriptionEvent
{
    /** @var string */
    const CANCEL   = 'stripe.local.subscription.cancel';
    /** @var string */
    const CANCELED = 'stripe.local.subscription.canceled';
    /** @var string */
    const FAILED   = 'stripe.local.subscription.cancel_failed';
}
