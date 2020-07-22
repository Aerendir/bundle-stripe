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

class StripeSubscriptionCancelEvent extends AbstractStripeSubscriptionEvent
{
    const CANCEL   = 'stripe.local.subscription.cancel';
    const CANCELED = 'stripe.local.subscription.canceled';
    const FAILED   = 'stripe.local.subscription.cancel_failed';
}
