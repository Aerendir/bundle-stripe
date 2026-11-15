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

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCard;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Component\ValueObjects\Money\Money;

/**
 * Abstract class to manage Charges.
 */
abstract class AbstractStripeChargeEvent extends AbstractStripeEvent
{
    private StripeLocalCharge $localCharge;

    public function __construct(StripeLocalCharge $charge)
    {
        $this->validate($charge);

        $this->localCharge = $charge;
    }

    public function getLocalCharge(): StripeLocalCharge
    {
        return $this->localCharge;
    }

    private function validate(StripeLocalCharge $charge)
    {
        if ( ! $charge->getAmount() instanceof Money) {
            throw new \InvalidArgumentException('You have to set an Amount to create a Charge.');
        }

        if ( ! $charge->getCustomer() instanceof StripeLocalCustomer && ! $charge->getSource() instanceof StripeLocalCard) {
            throw new \InvalidArgumentException('You have to set a Customer or a Source to create a Charge.');
        }
    }
}
