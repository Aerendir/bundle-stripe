<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\EventListener;

use SerendipityHQ\Bundle\StripeBundle\Service\StripeManager;
use Symfony\Contracts\EventDispatcher\EventSubscriberInterface;

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

    public function getStripeManager(): \SerendipityHQ\Bundle\StripeBundle\Service\StripeManager
    {
        return $this->stripeManager;
    }
}
