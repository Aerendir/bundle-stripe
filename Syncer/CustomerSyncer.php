<?php

/*
 * This file is part of the SerendipityHQ Stripe Bundle.
 *
 * Copyright (c) Adamo Crespi <hello@aerendir.me>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Syncer;

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCard;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalResourceInterface;
use SerendipityHQ\Component\ValueObjects\Email\Email;
use Stripe\ApiResource;
use Stripe\Customer;

/**
 * @author Adamo Crespi <hello@aerendir.me>
 *
 * @see https://stripe.com/docs/api#card_object
 */
class CustomerSyncer extends AbstractSyncer
{
    /**
     * {@inheritdoc}
     */
    public function syncLocalFromStripe(StripeLocalResourceInterface $localResource, ApiResource $stripeResource)
    {
        /** @var StripeLocalCustomer $localResource */
        if (!$localResource instanceof StripeLocalCustomer) {
            throw new \InvalidArgumentException('CustomerSyncer::syncLocalFromStripe() accepts only StripeLocalCustoer objects as first parameter.');
        }

        /** @var Customer $stripeResource */
        if (!$stripeResource instanceof Customer) {
            throw new \InvalidArgumentException('CustomerSyncer::syncLocalFromStripe() accepts only Stripe\Customer objects as second parameter.');
        }

        $reflect = new \ReflectionClass($localResource);

        foreach ($reflect->getProperties() as $reflectedProperty) {
            // Set the property as accessible
            $reflectedProperty->setAccessible(true);

            // Guess the kind and set its value
            switch ($reflectedProperty->getName()) {
                case 'id':
                    $reflectedProperty->setValue($localResource, $stripeResource->id);
                    break;

                case 'accountBalance':
                    $reflectedProperty->setValue($localResource, $stripeResource->account_balance);
                    break;

                case 'created':
                    $created = new \DateTime();
                    $reflectedProperty->setValue($localResource, $created->setTimestamp($stripeResource->created));
                    break;

                case 'currency':
                    $reflectedProperty->setValue($localResource, $stripeResource->currency);
                    break;

                case 'defaultSource':
                    $reflectedProperty->setValue($localResource, $stripeResource->default_source);
                    break;

                case 'delinquent':
                    $reflectedProperty->setValue($localResource, $stripeResource->delinquent);
                    break;

                case 'description':
                    $reflectedProperty->setValue($localResource, $stripeResource->description);
                    break;

                case 'email':
                    $reflectedProperty->setValue($localResource, new Email($stripeResource->email));
                    break;

                case 'livemode':
                    $reflectedProperty->setValue($localResource, $stripeResource->livemode);
                    break;

                case 'metadata':
                    $reflectedProperty->setValue($localResource, $stripeResource->metadata);
                    break;
            }
        }

        // Ever first persist the $localStripeResource: descendant syncers may require the object is known by the EntityManager.
        $this->getEntityManager()->persist($localResource);

        /*
         * Out of the foreach, process the deafult source to persist it.
         *
         * Other sources are simply ignored as, per the current structure of the bundle, each time a new card is created
         * for the customer, it is set as default.
         *
         * So, also if the customer changes his card, we for sure have it persisted locally due to this choice to only
         * persist default sources.
         *
         * If the customer has no cards, he gives data for a card for the first time. This card is created on Stripe and
         * set as the default one for the Customer. Here we get only the default card and so this first card is for sure
         * persisted. And so the subsequent cards.
         *
         * The cancellation process of a card is handled differently and does not concerns this updating process.
         */
        $stripeDefaultCard = $stripeResource->sources->retrieve($stripeResource->default_source);
        $localCard = $this->getEntityManager()->getRepository('StripeBundle:StripeLocalCard')->findOneByStripeId($stripeDefaultCard->id);

        // Chek if the card exists
        if (null === $localCard) {
            // It doesn't exist: create and persist it
            $localCard = new StripeLocalCard();
        }

        // Sync the local card with the remote object
        $this->getCardSyncer()->syncLocalFromStripe($localCard, $stripeDefaultCard);

        /*
         * Persist the card again: if it is a newly created card, we have to persist it, but, as the id of a local card
         * is its Stripe ID, we can persist it only after the sync.
         */
        $this->getEntityManager()->persist($localCard);

        // Now set the Card as default source of the StripeLocalCustomer object
        $defaultSourceProperty = $reflect->getProperty('defaultSource');
        $defaultSourceProperty->setAccessible(true);
        $defaultSourceProperty->setValue($localResource, $localCard);

        $this->getEntityManager()->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function syncStripeFromLocal(ApiResource $stripeResource, StripeLocalResourceInterface $localResource)
    {
        /** @var Customer $stripeResource */
        if (!$stripeResource instanceof Customer) {
            throw new \InvalidArgumentException('CustomerSyncer::syncStripeFromLocal() accepts only Stripe\Customer objects as first parameter.');
        }

        /** @var StripeLocalCustomer $localResource */
        if (!$localResource instanceof StripeLocalCustomer) {
            throw new \InvalidArgumentException('CustomerSyncer::syncStripeFromLocal() accepts only StripeLocalCustoer objects as second parameter.');
        }

        throw new \RuntimeException('Method not yet implemented');
    }
}
