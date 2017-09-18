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
 * Dispatched when a Customer has to be created.
 */
class StripeCustomerCreateEvent extends AbstractStripeCustomerEvent
{
    const CREATE  = 'stripe.local.customer.create';
    const CREATED = 'stripe.local.customer.created';
    const FAILED  = 'stripe.local.customer.create_failed';
}
