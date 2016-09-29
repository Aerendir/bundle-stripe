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

use Stripe\Card;
use Symfony\Component\EventDispatcher\Event;

/**
 * Dispatched when a new Card has to be created.
 */
class StripeSourceCreateEvent extends Event
{
    const CREATE  = 'stripe.local.source.create';
    const CREATED = 'stripe.local.source.created';
    const FAILED  = 'stripe.local.source.create_failed';
}
