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

/**
 * Dispatched when a Plan has to be created.
 */
final class StripePlanCreateEvent extends AbstractStripePlanEvent
{
    /** @var string */
    const CREATE  = 'stripe.local.plan.create';
    /** @var string */
    const CREATED = 'stripe.local.plan.created';
    /** @var string */
    const FAILED  = 'stripe.local.plan.create_failed';
}
