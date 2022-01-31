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
 * Dispatched when a Customer has to be created.
 */
final class StripeCustomerCreateEvent extends AbstractStripeCustomerEvent
{
    /** @var string */
    public const CREATE  = 'stripe.local.customer.create';

    /** @var string */
    public const CREATED = 'stripe.local.customer.created';

    /** @var string */
    public const FAILED  = 'stripe.local.customer.create_failed';
}
