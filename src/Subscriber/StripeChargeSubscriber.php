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

use SerendipityHQ\Bundle\StripeBundle\Event\StripeChargeCreateEvent;

/**
 * Manages Charges on Stripe.
 */
final class StripeChargeSubscriber extends AbstractStripeSubscriber
{
    public static function getSubscribedEvents(): array
    {
        return [
            StripeChargeCreateEvent::CREATE => 'onChargeCreate',
        ];
    }

    public function onChargeCreate(StripeChargeCreateEvent $event): void
    {
        $localCharge = $event->getLocalCharge();

        $result = $this->getStripeManager()->createCharge($localCharge);

        // Check if something went wrong
        if (false === $result) {
            // Stop propagation
            $event->setStopReason($this->getStripeManager()->getError())->stopPropagation();

            // Dispatch a failed event
            $this->getDispatcher()->dispatch($event, StripeChargeCreateEvent::FAILED);

            // exit
            return;
        }

        $this->getDispatcher()->dispatch($event, StripeChargeCreateEvent::CREATED);
    }
}
