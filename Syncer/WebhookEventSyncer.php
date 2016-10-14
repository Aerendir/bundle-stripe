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
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalWebhookEvent;
use SerendipityHQ\Component\ValueObjects\Email\Email;
use Stripe\ApiResource;
use Stripe\Customer;
use Stripe\Event;

/**
 * @author Adamo Crespi <hello@aerendir.me>
 *
 * @see https://stripe.com/docs/api#event_object
 */
class WebhookEventSyncer extends AbstractSyncer
{
    /**
     * {@inheritdoc}
     */
    public function syncLocalFromStripe(StripeLocalResourceInterface $localResource, ApiResource $stripeResource)
    {
        /** @var StripeLocalCustomer $localResource */
        if (!$localResource instanceof StripeLocalWebhookEvent) {
            throw new \InvalidArgumentException('WebhookEventSyncer::syncLocalFromStripe() accepts only StripeLocalWebhookEvent objects as first parameter.');
        }

        /** @var Customer $stripeResource */
        if (!$stripeResource instanceof Event) {
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

                case 'livemode':
                    $reflectedProperty->setValue($localResource, $stripeResource->livemode);
                    break;

                case 'pendingWebhooks':
                    $reflectedProperty->setValue($localResource, $stripeResource->pending_webhooks);
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

        // Now process the "data" property: here there are the object involved by this event
        switch ($stripeResource->data->object->object) {
            default:
                // The event type is not supported: persist data directly in the webhook_events table, in the event's row
                $localResource->setData($stripeResource->data->object->__toString());
            /*
                case '':
                $stripeDefaultCard = $stripeResource->sources->retrieve($stripeResource->default_source);
                $localCard = $this->getEntityManager()->getRepository('StripeBundle:StripeLocalCard')->findOneBy(['id' => $stripeDefaultCard->id]);

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
                 *
                $this->getEntityManager()->persist($localCard);

                // Now set the Card as default source of the StripeLocalCustomer object
                $defaultSourceProperty = $reflect->getProperty('defaultSource');
                $defaultSourceProperty->setAccessible(true);
                $defaultSourceProperty->setValue($localResource, $localCard);
                break;
            */
        }

        $this->getEntityManager()->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function syncStripeFromLocal(ApiResource $stripeResource, StripeLocalResourceInterface $localResource)
    {
        throw new \BadMethodCallException('You cannot synchronize a Stripe\Event from a StripeLocalWebhookEvent.');
    }
}
