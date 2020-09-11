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

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;

/**
 * Abstract class to manage Charges.
 */
abstract class AbstractStripeChargeEvent extends AbstractStripeEvent
{
    /** @var StripeLocalCharge $localCharge */
    private $localCharge;

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
        if (null === $charge->getAmount()) {
            throw new \InvalidArgumentException('You have to set an Amount to create a Charge.');
        }

        if (null === $charge->getCustomer() && null === $charge->getSource()) {
            throw new \InvalidArgumentException('You have to set a Customer or a Source to create a Charge.');
        }
    }
}
