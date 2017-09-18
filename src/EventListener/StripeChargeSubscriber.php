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

use SerendipityHQ\Bundle\StripeBundle\Event\StripeChargeCreateEvent;
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

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
            StripeChargeCreateEvent::CREATE => 'onChargeCreate',
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
            $event->setStopReason($this->getStripeManager()->getError())->stopPropagation();

            // Dispatch a failed event
            $dispatcher->dispatch(StripeChargeCreateEvent::FAILED, $event);

            // exit
            return;
        }

        $dispatcher->dispatch(StripeChargeCreateEvent::CREATED, $event);
    }
}
