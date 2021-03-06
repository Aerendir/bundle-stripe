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

use SerendipityHQ\Bundle\StripeBundle\Event\StripeCustomerCreateEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeCustomerUpdateEvent;

/**
 * Manages Customers on Stripe.
 */
final class StripeCustomerSubscriber extends AbstractStripeSubscriber
{
    public static function getSubscribedEvents(): array
    {
        return [
            StripeCustomerCreateEvent::CREATE => 'onCustomerCreate',
            StripeCustomerUpdateEvent::UPDATE => 'onCustomerUpdate',
        ];
    }

    public function onCustomerCreate(StripeCustomerCreateEvent $event): void
    {
        $localCustomer = $event->getLocalCustomer();

        // To create a Customer the currency parameter is not allowed.
        // So, if in our app we get it, when creating the customer we lose it.
        // We save the currency here to add it again later.
        $currency = $localCustomer->getCurrency();

        $result = $this->getStripeManager()->createCustomer($localCustomer);

        // Check if something went wrong
        if (false === $result) {
            // Stop progation
            $event->setStopReason($this->getStripeManager()->getError())->stopPropagation();

            // Dispatch a failed event
            $this->getDispatcher()->dispatch($event, StripeCustomerCreateEvent::FAILED);

            // exit
            return;
        }

        if (null !== $currency) {
            // We readd the currency to the object to be sure to save it to the database.
            // It is allowed when charging the customer or updating it.
            $localCustomer->setCurrency($currency);
        }

        $this->getDispatcher()->dispatch($event, StripeCustomerCreateEvent::CREATED);
    }

    public function onCustomerUpdate(StripeCustomerUpdateEvent $event): void
    {
        $localCustomer = $event->getLocalCustomer();

        $result = $this->getStripeManager()->updateCustomer($localCustomer, $event->hasToSyncSources());

        // Check if something went wrong
        if (false === $result) {
            // Stop progation
            $event->setStopReason($this->getStripeManager()->getError())->stopPropagation();

            // Dispatch a failed event
            $this->getDispatcher()->dispatch($event, StripeCustomerUpdateEvent::FAILED);

            // exit
            return;
        }

        $this->getDispatcher()->dispatch($event, StripeCustomerUpdateEvent::UPDATED);
    }
}
