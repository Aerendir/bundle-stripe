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

namespace SerendipityHQ\Bundle\StripeBundle\Subscriber;

use SerendipityHQ\Bundle\StripeBundle\Manager\StripeManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Manages Charges on Stripe.
 */
abstract class AbstractStripeSubscriber implements EventSubscriberInterface
{
    /** @var EventDispatcherInterface $dispatcher */
    private $dispatcher;

    /** @var StripeManager $stripeManager */
    private $stripeManager;

    public function __construct(EventDispatcherInterface $dispatcher, StripeManager $stripeManager)
    {
        $this->stripeManager = $stripeManager;
    }

    /**
     * @return EventDispatcherInterface
     */
    public function getDispatcher() : EventDispatcherInterface
    {
        return $this->dispatcher;
    }

    public function getStripeManager(): StripeManager
    {
        return $this->stripeManager;
    }
}
