<?php

/*
 * This file is part of the SerendipityHQ Stripe Bundle.
 *
 * Copyright (c) Adamo Crespi <hello@aerendir.me>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\EventListener;

use SerendipityHQ\Bundle\StripeBundle\Event\StripeChargeCreateEvent;
use SerendipityHQ\Bundle\StripeBundle\Service\StripeManager;
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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
