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

use SerendipityHQ\Bundle\StripeBundle\Event\StripeSourceCreateEvent;
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Manages CreditCards on Stripe.
 */
class StripeSourceSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            StripeSourceCreateEvent::CREATE => 'onSourceCreate',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * At this point the card is already created through Stripe.js. Stripe.js returned us a token representation of the card
     * that we set in the form via JavaScript.
     *
     * Once the card token were returned and set in the form via JavaScript, the form itself were submitted.
     *
     * Now we only remains to link the card token with the Stripe StripeLocalCustomer to make the card's creation definitive.
     *
     * @param StripeSourceCreateEvent $event
     * @param $eventName
     * @param ContainerAwareEventDispatcher $dispatcher The passed EventDispatcher gives anyway access to the container,
     *                                                  also if the autocompletion doesn't report it. There is something
     *                                                  missed in comments in the Symfony Framework
     */
    public function onSourceCreate(StripeSourceCreateEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        die(dump($event));
    }

    /**
     * @param StripeSourceCreateEvent $event
     * @param $eventName
     * @param ContainerAwareEventDispatcher $dispatcher The passed EventDispatcher gives anyway access to the container,
     *                                                  also if the autocompletion doesn't report it. There is something
     *                                                  missed in comments in the Symfony Framework
     */
    public function onStripeSourceCreated(StripeSourceCreateEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $dispatcher->getContainer()->get('doctrine.orm.default_entity_manager');

        /** @var StripeManager $stripe */
        $stripe = $dispatcher->getContainer()->get('stripe_bundle.manager');

        /** @var Customer $stripeCustomer */
        $stripeCustomer = $stripe->getCustomer($event->getCustomerId());

        /** @var Company $company Find the company */
        $company = $entityManager->getRepository('AppBundle:Company')->findOneBy(['stripeCustomer' => $event->getCustomerId()]);

        // Remove all the cards from the Company
        foreach ($company->getCreditCard() as $card) {
            $company->removeCreditCard($card);
        }

        /** @var Card $card Find the default source */
        foreach ($stripeCustomer->sources['data'] as $card) {
            if ($stripeCustomer->default_source === $card->id) {
                $newCard = new Card($card);
                $company->addCreditCard($newCard);
                $entityManager->persist($newCard);
                continue;
            }
        }

        $entityManager->flush();

        $companyEvent = new CompanyEvent();
        $companyEvent->setResult(true)->updatedCompany($company);
        $dispatcher->dispatch(CompanyEvent::UPDATED, $companyEvent);
    }
}
