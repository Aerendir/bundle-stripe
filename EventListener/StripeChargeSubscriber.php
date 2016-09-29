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
class StripeChargeSubscriber extends AbstractStripeSubscriber
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            StripeChargeCreateEvent::CREATE => 'onChargeCreate'
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @param StripeChargeCreateEvent $event
     * @param $eventName
     * @param ContainerAwareEventDispatcher|EventDispatcherInterface $dispatcher
     */
    public function onChargeCreate(StripeChargeCreateEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $localCharge = $event->getLocalCharge();

        $result = $this->getStripeManager()->createCharge($localCharge);

        // Check if something went wrong
        if (false === $result) {
            // Stop progation
            $event->stopPropagation();

            // Dispatch a failed event
            $dispatcher->dispatch(StripeChargeCreateEvent::FAILED, $event);

            // exit
            return;
        }

        $dispatcher->dispatch(StripeChargeCreateEvent::CREATED, $event);
    }
}
