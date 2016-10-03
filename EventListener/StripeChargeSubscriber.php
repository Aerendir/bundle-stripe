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
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Manages Charges on Stripe.
 */
class StripeChargeSubscriber implements EventSubscriberInterface
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
     * @param ContainerAwareEventDispatcher $dispatcher The passed EventDispatcher gives anyway access to the container,
     *                                                  also if the autocompletion doesn't report it. There is something
     *                                                  missed in comments in the Symfony Framework
     */
    public function onChargeCreate(StripeChargeCreateEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        die(dump($event));
    }
}
