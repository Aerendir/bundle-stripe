<?php

/*
 * This file is part of the SerendipityHQ Stripe Bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Event;

/**
 * Dispatched when a Plan has to be created.
 */
class StripePlanCreateEvent extends AbstractStripePlanEvent
{
    const CREATE = 'stripe.local.plan.create';
    const CREATED = 'stripe.local.plan.created';
    const FAILED = 'stripe.local.plan.create_failed';
}
