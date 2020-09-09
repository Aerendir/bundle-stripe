<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Syncer;

use Doctrine\ORM\EntityManagerInterface;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCard;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalResourceInterface;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalSubscription;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalWebhookEvent;
use Stripe\ApiResource;
use Stripe\Customer;
use Stripe\Event;

/**
 * @author Adamo Crespi <hello@aerendir.me>
 *
 * @see https://stripe.com/docs/api#event_object
 */
final class WebhookEventSyncer extends AbstractSyncer
{
    /** @var CardSyncer $cardSyncer */
    private $cardSyncer;

    /** @var ChargeSyncer $chargeSyncer */
    private $chargeSyncer;

    /** @var CustomerSyncer $customerSyncer */
    private $customerSyncer;

    /** @var SubscriptionSyncer $subscriptionSyncer */
    private $subscriptionSyncer;

    public function __construct(
        EntityManagerInterface $entityManager,
        CardSyncer $cardSyncer,
        ChargeSyncer $chargeSyncer,
        CustomerSyncer $customerSyncer,
        SubscriptionSyncer $subscriptionSyncer
    ) {
        parent::__construct($entityManager);
        $this->cardSyncer         = $cardSyncer;
        $this->chargeSyncer       = $chargeSyncer;
        $this->customerSyncer     = $customerSyncer;
        $this->subscriptionSyncer = $subscriptionSyncer;
    }

    public function syncLocalFromStripe(StripeLocalResourceInterface $localResource, ApiResource $stripeResource): void
    {
        /** @var StripeLocalCustomer $localResource */
        if ( ! $localResource instanceof StripeLocalWebhookEvent) {
            throw new \InvalidArgumentException('WebhookEventSyncer::syncLocalFromStripe() accepts only StripeLocalWebhookEvent objects as first parameter.');
        }

        /** @var Customer $stripeResource */
        if ( ! $stripeResource instanceof Event) {
            throw new \InvalidArgumentException('WebhookEventSyncer::syncLocalFromStripe() accepts only Stripe\Event objects as second parameter.');
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

                case 'created':
                    $created = new \DateTime();
                    $reflectedProperty->setValue($localResource, $created->setTimestamp($stripeResource->created));
                    break;

                case 'data':
                    $reflectedProperty->setValue($localResource, $stripeResource->data->__toString());
                    break;

                case 'livemode':
                    $reflectedProperty->setValue($localResource, $stripeResource->livemode);
                    break;

                case 'pendingWebhooks':
                    $reflectedProperty->setValue($localResource, $stripeResource->pendingWebhooks);
                    break;

                case 'request':
                    $reflectedProperty->setValue($localResource, $stripeResource->request);
                    break;

                case 'type':
                    $reflectedProperty->setValue($localResource, $stripeResource->type);
                    break;
            }
        }

        // Ever first persist the $localStripeResource: descendant syncers may require the object is known by the EntityManager.
        $this->getEntityManager()->persist($localResource);
        $this->getEntityManager()->flush();

        $stripeObjectData = $stripeResource->data->object;
        // Now process the "data" property: here there are the objects involved by this event
        switch ($stripeObjectData->object) {
            case 'charge':
                // Get the Charge from the database
                $localCharge = $this->getEntityManager()->getRepository(StripeLocalCharge::class)->findOneByStripeId($stripeObjectData->id);

                // Create the new Local object if it doesn't exist
                if (null === $localCharge) {
                    $localCharge = new StripeLocalCharge();
                }

                // Sync the local object with the remote one
                $this->chargeSyncer->syncLocalFromStripe($localCharge, $stripeObjectData);
                break;

            case 'customer':
                // Get the Charge from the database
                $localCustomer = $this->getEntityManager()->getRepository(StripeLocalCustomer::class)->findOneByStripeId($stripeObjectData->id);

                // Create the new Local object if it doesn't exist
                if (null === $localCustomer) {
                    $localCustomer = new StripeLocalCustomer();
                }

                // Sync the local object with the remote one
                $this->customerSyncer->syncLocalFromStripe($localCustomer, $stripeResource->data->object);
                break;

            case 'subscription':
                // Get the Subscription from the database
                $localSubscription = $this->getEntityManager()->getRepository(StripeLocalSubscription::class)->findOneByStripeId($stripeObjectData->id);

                // Create the new Local object if it doesn't exist
                if (null === $localSubscription) {
                    $localSubscription = new StripeLocalSubscription();
                }

                // Sync the local object with the remote one
                $this->subscriptionSyncer->syncLocalFromStripe($localSubscription, $stripeResource->data->object);
                break;

            case 'source':
                // If the source is a card, process it (maybe it is a bitcoin source that is not supported)
                if ('card' === $stripeObjectData->source->object) {
                    // Get the loca l object
                    $localCard = $this->getEntityManager()->getRepository(StripeLocalCard::class)->findOneByStripeId($stripeObjectData->source->id);

                    // Chek if the card exists
                    if (null === $localCard) {
                        // It doesn't exist: create and persist it
                        $localCard = new StripeLocalCard();
                    }

                    // Sync the local card with the remote object
                    $this->cardSyncer->syncLocalFromStripe($localCard, $stripeObjectData->source);
                }
                break;
        }

        $this->getEntityManager()->flush();
    }

    public function syncStripeFromLocal(ApiResource $stripeResource, StripeLocalResourceInterface $localResource): void
    {
        throw new \BadMethodCallException('You cannot synchronize a Stripe\Event from a StripeLocalWebhookEvent.');
    }
}
