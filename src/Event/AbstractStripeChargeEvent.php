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

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;

/**
 * Abstract class to manage Charges.
 */
abstract class AbstractStripeChargeEvent extends AbstractStripeEvent
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
