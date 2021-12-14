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

namespace SerendipityHQ\Bundle\StripeBundle\Syncer;

use Doctrine\Common\Proxy\Proxy;
use Doctrine\ORM\EntityManagerInterface;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCard;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalResourceInterface;
use SerendipityHQ\Component\ValueObjects\Email\Email;
use Stripe\ApiResource;
use Stripe\Card;
use Stripe\Collection;
use Stripe\Customer;

/**
 * @author Adamo Crespi <hello@aerendir.me>
 *
 * @see https://stripe.com/docs/api#card_object
 */
final class CustomerSyncer extends AbstractSyncer
{
    /** @var CardSyncer $cardSyncer */
    private $cardSyncer;

    public function __construct(
        EntityManagerInterface $entityManager,
        CardSyncer $cardSyncer
    ) {
        parent::__construct($entityManager);
        $this->cardSyncer = $cardSyncer;
    }

    public function syncLocalFromStripe(StripeLocalResourceInterface $localResource, ApiResource $stripeResource): void
    {
        /** @var StripeLocalCustomer $localResource */
        if ( ! $localResource instanceof StripeLocalCustomer) {
            throw new \InvalidArgumentException('CustomerSyncer::syncLocalFromStripe() accepts only StripeLocalCustoer objects as first parameter.');
        }

        /** @var Customer $stripeResource */
        if ( ! $stripeResource instanceof Customer) {
            throw new \InvalidArgumentException('CustomerSyncer::syncLocalFromStripe() accepts only Stripe\Customer objects as second parameter.');
        }

        $reflect = new \ReflectionClass($localResource);

        if ($localResource instanceof Proxy) {
            $reflect = $reflect->getParentClass();
        }

        foreach ($reflect->getProperties() as $reflectedProperty) {
            // Set the property as accessible
            $reflectedProperty->setAccessible(true);

            // Guess the kind and set its value
            switch ($reflectedProperty->getName()) {
                case 'id':
                    $reflectedProperty->setValue($localResource, $stripeResource->id);

                    break;

                case 'balance':
                    $reflectedProperty->setValue($localResource, $stripeResource->balance);

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
                    // If the email were not passed to Stripe, this property is null and so cannot be set in the Email object
                    if (null !== $stripeResource->email) {
                        $reflectedProperty->setValue($localResource, new Email($stripeResource->email));
                    }

                    break;

                case 'livemode':
                    $reflectedProperty->setValue($localResource, $stripeResource->livemode);

                    break;

                case 'metadata':
                    $reflectedProperty->setValue($localResource, $stripeResource->metadata->toArray());

                    break;
            }
        }

        // Ever first persist the $localStripeResource: descendant syncers may require the object is known by the EntityManager.
        $this->getEntityManager()->persist($localResource);

        /*
         * Out of the foreach, process the default source to persist it.
         *
         * Other sources are simply ignored as, per the current structure of the bundle, each time a new card is created
         * for the customer, it is set as default.
         *
         * So, also if the customer changes his card, we for sure have it persisted locally due to this choice to only
         * persist default sources.
         *
         * If the customer has no cards, (s)he gives data for a card for the first time. This card is created on Stripe and
         * set as the default one for the Customer. Here we get only the default card and so this first card is for sure
         * persisted. And so the subsequent cards.
         *
         * The cancellation process of a card is handled differently and does not concern this updating process.
         */
        $stripeDefaultCard = \Stripe\Customer::retrieveSource($stripeResource->id, $stripeResource->default_source);
        $localCard         = $this->getEntityManager()->getRepository(StripeLocalCard::class)->findOneByStripeId($stripeDefaultCard->id);

        // Chek if the card exists
        if (null === $localCard) {
            // It doesn't exist: create and persist it
            $localCard = new StripeLocalCard();
        }

        // Sync the local card with the remote object
        $this->cardSyncer->syncLocalFromStripe($localCard, $stripeDefaultCard);

        /*
         * Persist the card again: if it is a newly created card, we have to persist it, but, as the id of a local card
         * is its Stripe ID, we can persist it only after the sync.
         */
        $this->getEntityManager()->persist($localCard);

        // Now set the Card as default source of the StripeLocalCustomer object
        $defaultSourceProperty = $reflect->getProperty('defaultSource');
        $defaultSourceProperty->setAccessible(true);
        $defaultSourceProperty->setValue($localResource, $localCard);

        $this->getEntityManager()->persist($localResource);
        $this->getEntityManager()->flush();
    }

    public function syncStripeFromLocal(ApiResource $stripeResource, StripeLocalResourceInterface $localResource): void
    {
        /** @var Customer $stripeResource */
        if ( ! $stripeResource instanceof Customer) {
            throw new \InvalidArgumentException('CustomerSyncer::syncStripeFromLocal() accepts only Stripe\Customer objects as first parameter.');
        }

        /** @var StripeLocalCustomer $localResource */
        if ( ! $localResource instanceof StripeLocalCustomer) {
            throw new \InvalidArgumentException('CustomerSyncer::syncStripeFromLocal() accepts only StripeLocalCustoer objects as second parameter.');
        }

        if (null !== $localResource->getBalance()) {
            $stripeResource->balance = $localResource->getBalance();
        }

        if (null !== $localResource->getNewSource()) {
            $stripeResource->source = $localResource->getNewSource();
        }

        if (null !== $localResource->getDescription()) {
            $stripeResource->description = $localResource->getDescription();
        }

        if (null !== $localResource->getEmail()) {
            $stripeResource->email = $localResource->getEmail();
        }

        if (null !== $localResource->getMetadata()) {
            $stripeResource->metadata = $localResource->getMetadata();
        }
    }

    public function syncLocalSources(StripeLocalResourceInterface $localResource, ApiResource $stripeResource): void
    {
        /** @var StripeLocalCustomer $localResource */
        if ( ! $localResource instanceof StripeLocalCustomer) {
            throw new \InvalidArgumentException('CustomerSyncer::syncLocalFromStripe() accepts only StripeLocalCustomer objects as first parameter.');
        }

        /** @var Customer $stripeResource */
        if ( ! $stripeResource instanceof Customer) {
            throw new \InvalidArgumentException('CustomerSyncer::syncLocalFromStripe() accepts only Stripe\Customer objects as second parameter.');
        }

        // Now, be sure the sources are in sync
        foreach ($localResource->getCards() as $card) {
            if (null === $stripeResource->sources) {
                \dd($stripeResource);
            }
            if (false === $this->sourceExists($card, $stripeResource->sources)) {
                // The card doesn't exists on the Stripe account: remove it from the local one
                $this->getEntityManager()->remove($card);
            }
        }

        $this->getEntityManager()->persist($localResource);
        $this->getEntityManager()->flush();
    }

    /**
     * Checks if the given card is set source in the StripeCustomer object.
     *
     * Perform this check guarantees that the local database is always in sync with the Stripe Account.
     */
    private function sourceExists(StripeLocalCard $card, Collection $sources): bool
    {
        /** @var Card $source */
        foreach ($sources->data as $source) {
            if ($card->getId() === $source->id) {
                return true;
            }
        }

        return false;
    }
}
