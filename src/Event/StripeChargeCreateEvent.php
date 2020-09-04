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
 * Dispatched when a new Charge has to be created.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
final class StripeChargeCreateEvent extends AbstractStripeChargeEvent
{
    /** @var string */
    const CREATE  = 'stripe.local.charge.create';
    /** @var string */
    const CREATED = 'stripe.local.charge.created';
    /** @var string */
    const FAILED  = 'stripe.local.charge.create_failed';
}
