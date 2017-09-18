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
 * Dispatched when a Customer has to be created.
 */
class StripeCustomerCreateEvent extends AbstractStripeCustomerEvent
{
    const CREATE = 'stripe.local.customer.create';
    const CREATED = 'stripe.local.customer.created';
    const FAILED = 'stripe.local.customer.create_failed';
}
