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

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;
use Symfony\Component\EventDispatcher\Event;

/**
 * Abstract class to manage Charges.
 */
class AbstractStripeChargeEvent extends Event
{
    /** @var StripeLocalCharge $localCharge */
    private $localCharge;

    /**
     * @param StripeLocalCharge $charge
     */
    public function __construct(StripeLocalCharge $charge)
    {
        $this->validate($charge);

        $this->localCharge = $charge;
    }

    /**
     * @return StripeLocalCharge
     */
    public function getLocalCharge()
    {
        return $this->localCharge;
    }

    /**
     * @param StripeLocalCharge $charge
     */
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
