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

use SerendipityHQ\Bundle\StripeBundle\Event\StripePlanCreateEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripePlanUpdateEvent;
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Components\EventDispatcher\EventDispatcherInterface;

/**
 * Manages Plan on Stripe.
 */
final class StripePlanSubscriber extends AbstractStripeSubscriber
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            StripePlanCreateEvent::CREATE => 'onPlanCreate',
            StripePlanUpdateEvent::UPDATE => 'onPlanUpdate',
        ];
    }

    /**
     * @param $eventName
     * @param ContainerAwareEventDispatcher|EventDispatcherInterface $dispatcher
     */
    public function onPlanCreate(StripePlanCreateEvent $event, $eventName, EventDispatcherInterface $dispatcher): void
    {
        $localPlan = $event->getLocalPlan();

        $result = $this->getStripeManager()->createPlan($localPlan);

        // Check if something went wrong
        if (false === $result) {
            // Stop progation
            $event->stopPropagation();

            // Dispatch a failed event
            $dispatcher->dispatch($event, StripePlanCreateEvent::FAILED);

            // exit
            return;
        }

        $dispatcher->dispatch($event, StripePlanCreateEvent::CREATED);
    }

    /**
     * @param $eventName
     * @param ContainerAwareEventDispatcher|EventDispatcherInterface $dispatcher
     */
    public function onPlanUpdate(StripePlanUpdateEvent $event, $eventName, EventDispatcherInterface $dispatcher): void
    {
        $localPlan = $event->getLocalPlan();

        $result = $this->getStripeManager()->updatePlan($localPlan, $event->hasToSyncSources());

        // Check if something went wrong
        if (false === $result) {
            // Stop progation
            $event->stopPropagation();

            // Dispatch a failed event
            $dispatcher->dispatch($event, StripePlanUpdateEvent::FAILED);

            // exit
            return;
        }

        $dispatcher->dispatch($event, StripePlanUpdateEvent::UPDATED);
    }
}
