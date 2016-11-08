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

use SerendipityHQ\Bundle\StripeBundle\Event\StripeCustomerCreateEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeCustomerUpdateEvent;
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Manages Customers on Stripe.
 */
class StripeCustomerSubscriber extends AbstractStripeSubscriber
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            StripeCustomerCreateEvent::CREATE => 'onCustomerCreate',
            StripeCustomerUpdateEvent::UPDATE => 'onCustomerUpdate'
        ];
    }

    /**
     * @param StripeCustomerCreateEvent $event
     * @param $eventName
     * @param ContainerAwareEventDispatcher|EventDispatcherInterface $dispatcher
     */
    public function onCustomerCreate(StripeCustomerCreateEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $localCustomer = $event->getLocalCustomer();

        $result = $this->getStripeManager()->createCustomer($localCustomer);

        // Check if something went wrong
        if (false === $result) {
            // Stop progation
            $event->stopPropagation();

            // Dispatch a failed event
            $dispatcher->dispatch(StripeCustomerCreateEvent::FAILED, $event);

            // exit
            return;
        }

        $dispatcher->dispatch(StripeCustomerCreateEvent::CREATED, $event);
    }

    /**
     * @param StripeCustomerUpdateEvent $event
     * @param $eventName
     * @param ContainerAwareEventDispatcher|EventDispatcherInterface $dispatcher
     */
    public function onCustomerUpdate(StripeCustomerUpdateEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $localCustomer = $event->getLocalCustomer();

        $result = $this->getStripeManager()->updateCustomer($localCustomer, $event->hasToSyncSources());

        // Check if something went wrong
        if (false === $result) {
            // Stop progation
            $event->stopPropagation();

            // Dispatch a failed event
            $dispatcher->dispatch(StripeCustomerUpdateEvent::FAILED, $event);

            // exit
            return;
        }

        $dispatcher->dispatch(StripeCustomerUpdateEvent::UPDATED, $event);
    }
}
