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

use SerendipityHQ\Bundle\StripeBundle\Event\StripePlanCreateEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripePlanUpdateEvent;
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Manages Plan on Stripe.
 */
class StripePlanSubscriber extends AbstractStripeSubscriber
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            StripePlanCreateEvent::CREATE => 'onPlanCreate',
            StripePlanUpdateEvent::UPDATE => 'onPlanUpdate',
        ];
    }

    /**
     * @param StripePlanCreateEvent $event
     * @param $eventName
     * @param ContainerAwareEventDispatcher|EventDispatcherInterface $dispatcher
     */
    public function onPlanCreate(StripePlanCreateEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $localPlan = $event->getLocalPlan();

        $result = $this->getStripeManager()->createPlan($localPlan);

        // Check if something went wrong
        if (false === $result) {
            // Stop progation
            $event->stopPropagation();

            // Dispatch a failed event
            $dispatcher->dispatch(StripePlanCreateEvent::FAILED, $event);

            // exit
            return;
        }

        $dispatcher->dispatch(StripePlanCreateEvent::CREATED, $event);
    }

    /**
     * @param StripePlanUpdateEvent $event
     * @param $eventName
     * @param ContainerAwareEventDispatcher|EventDispatcherInterface $dispatcher
     */
    public function onPlanUpdate(StripePlanUpdateEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $localPlan = $event->getLocalPlan();

        $result = $this->getStripeManager()->updatePlan($localPlan, $event->hasToSyncSources());

        // Check if something went wrong
        if (false === $result) {
            // Stop progation
            $event->stopPropagation();

            // Dispatch a failed event
            $dispatcher->dispatch(StripePlanUpdateEvent::FAILED, $event);

            // exit
            return;
        }

        $dispatcher->dispatch(StripePlanUpdateEvent::UPDATED, $event);
    }
}
