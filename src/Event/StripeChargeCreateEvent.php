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
 * Dispatched when a new Charge has to be created.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
class StripeChargeCreateEvent extends AbstractStripeChargeEvent
{
    const CREATE = 'stripe.local.charge.create';
    const CREATED = 'stripe.local.charge.created';
    const FAILED = 'stripe.local.charge.create_failed';
}
