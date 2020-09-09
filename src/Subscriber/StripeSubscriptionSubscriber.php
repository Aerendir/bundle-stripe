<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Subscriber;

use SerendipityHQ\Bundle\StripeBundle\Event\StripeSubscriptionCancelEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeSubscriptionCreateEvent;
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Components\EventDispatcher\EventDispatcherInterface;

/**
 * Manages Subscriptions on Stripe.
 */
final class StripeSubscriptionSubscriber extends AbstractStripeSubscriber
{
    public static function getSubscribedEvents(): array
    {
        return [
            StripeSubscriptionCreateEvent::CREATE => 'onSubscriptionCreate',
            StripeSubscriptionCancelEvent::CANCEL => 'onSubscriptionCancel',
        ];
    }

    /**
     * @param $eventName
     * @param ContainerAwareEventDispatcher|EventDispatcherInterface $dispatcher
     */
    public function onSubscriptionCreate(StripeSubscriptionCreateEvent $event, $eventName, EventDispatcherInterface $dispatcher): void
    {
        $localSubscription = $event->getLocalSubscription();

        $result = $this->getStripeManager()->createSubscription($localSubscription);

        // Check if something went wrong
        if (false === $result) {
            // Stop progation
            $event->setStopReason($this->getStripeManager()->getError())->stopPropagation();

            // Dispatch a failed event
            $dispatcher->dispatch($event, StripeSubscriptionCreateEvent::FAILED);

            // exit
            return;
        }

        $dispatcher->dispatch($event, StripeSubscriptionCreateEvent::CREATED);
    }

    /**
     * @param $eventName
     * @param ContainerAwareEventDispatcher|EventDispatcherInterface $dispatcher
     */
    public function onSubscriptionCancel(StripeSubscriptionCancelEvent $event, $eventName, EventDispatcherInterface $dispatcher): void
    {
        $localSubscription = $event->getLocalSubscription();

        $localSubscription->setCancelAtPeriodEnd(true);

        $result = $this->getStripeManager()->cancelSubscription($localSubscription);

        // Check if something went wrong
        if (false === $result) {
            // Stop progation
            $event->setStopReason($this->getStripeManager()->getError())->stopPropagation();

            // Dispatch a failed event
            $dispatcher->dispatch($event, StripeSubscriptionCancelEvent::FAILED);

            // exit
            return;
        }

        $dispatcher->dispatch($event, StripeSubscriptionCancelEvent::CANCELED);
    }
}
