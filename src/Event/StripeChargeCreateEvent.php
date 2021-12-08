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
 * Dispatched when a new Charge has to be created.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
final class StripeChargeCreateEvent extends AbstractStripeChargeEvent
{
    /** @var string */
    public const CREATE  = 'stripe.local.charge.create';
    /** @var string */
    public const CREATED = 'stripe.local.charge.created';
    /** @var string */
    public const FAILED  = 'stripe.local.charge.create_failed';
}
