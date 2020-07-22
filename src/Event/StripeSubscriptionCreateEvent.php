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

class StripeSubscriptionCreateEvent extends AbstractStripeSubscriptionEvent
{
    const CREATE  = 'stripe.local.subscription.create';
    const CREATED = 'stripe.local.subscription.created';
    const FAILED  = 'stripe.local.subscription.create_failed';
}
