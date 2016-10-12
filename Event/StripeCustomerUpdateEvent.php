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

use Stripe\Customer;

/**
 * Dispatched when a Cusrtomer has to be updated.
 */
class StripeCustomerUpdateEvent extends AbstractStripeCustomerEvent
{
    const UPDATE = 'stripe.local.customer.update';
    const UPDATED = 'stripe.local.customer.updated';
    const FAILED = 'stripe.local.customer.update_failed';
}
