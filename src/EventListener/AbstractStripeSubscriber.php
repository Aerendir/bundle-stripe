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

namespace SerendipityHQ\Bundle\StripeBundle\EventListener;

use SerendipityHQ\Bundle\StripeBundle\Service\StripeManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Manages Charges on Stripe.
 */
abstract class AbstractStripeSubscriber implements EventSubscriberInterface
{
    /** @var StripeManager $stripeManager */
    private $stripeManager;

    /**
     * @param StripeManager $stripeManager
     */
    public function __construct(StripeManager $stripeManager)
    {
        $this->stripeManager = $stripeManager;
    }

    /**
     * @return StripeManager
     */
    public function getStripeManager()
    {
        return $this->stripeManager;
    }
}
