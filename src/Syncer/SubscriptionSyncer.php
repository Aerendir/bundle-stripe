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

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalResourceInterface;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalSubscription;
use Stripe\ApiResource;
use Stripe\Subscription;

/**
 * @see https://stripe.com/docs/api#subscription_object
 */
final class SubscriptionSyncer extends AbstractSyncer
{
    public function syncLocalFromStripe(StripeLocalResourceInterface $localResource, ApiResource $stripeResource): void
    {
        /** @var StripeLocalSubscription $localResource */
        if ( ! $localResource instanceof StripeLocalSubscription) {
            throw new \InvalidArgumentException('SubscriptionSyncer::syncLocalFromStripe() accepts only StripeLocalSubscription objects as first parameter.');
        }

        /** @var Subscription $stripeResource */
        if ( ! $stripeResource instanceof Subscription) {
            throw new \InvalidArgumentException('SubscriptionSyncer::syncLocalFromStripe() accepts only Stripe\Subscription objects as second parameter.');
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

                case 'applicationFeePercent':
                    $reflectedProperty->setValue($localResource, $stripeResource->applicationFeePercent);
                    break;

                case 'cancelAtPeriodEnd':
                    $reflectedProperty->setValue($localResource, $stripeResource->cancelAtPeriodAt);
                    break;

                case 'canceledAt':
                    $reflectedProperty->setValue($localResource, $stripeResource->canceledAt);
                    break;

                case 'created':
                    $created = new \DateTime();
                    $reflectedProperty->setValue($localResource, $created->setTimestamp($stripeResource->created));
                    break;

                case 'currentPeriodEnd':
                    $currentPeriodEnd = new \DateTime();
                    $reflectedProperty->setValue($localResource, $currentPeriodEnd->setTimestamp($stripeResource->currentPeriodEnd));
                    break;

                case 'currentPeriodStart':
                    $currentPeriodStart = new \DateTime();
                    $reflectedProperty->setValue($localResource, $currentPeriodStart->setTimestamp($stripeResource->currentPeriodStart));
                    break;

                case 'discount':
                    $reflectedProperty->setValue($localResource, $stripeResource->discount);
                    break;

                case 'endedAt':
                    $endedAt = new \DateTime();
                    $reflectedProperty->setValue($localResource, $endedAt->setTimestamp($stripeResource->endedAt));
                    break;

                case 'livemode':
                    $reflectedProperty->setValue($localResource, $stripeResource->livemode);
                    break;

                case 'metadata':
                    $reflectedProperty->setValue($localResource, $stripeResource->metadata);
                    break;

                case 'plan':
                    $reflectedProperty->setValue($localResource, $stripeResource->plan);
                    break;

                case 'quantity':
                    $reflectedProperty->setValue($localResource, $stripeResource->quantity);
                    break;

                case 'start':
                    $start = new \DateTime();
                    $reflectedProperty->setValue($localResource, $start->setTimestamp($stripeResource->start));
                    break;

                case 'status':
                    $reflectedProperty->setValue($localResource, $stripeResource->status);
                    break;

                case 'taxPercent':
                    $reflectedProperty->setValue($localResource, $stripeResource->taxPercent);
                    break;

                case 'trialEnd':
                    $trialEnd = new \DateTime();
                    $reflectedProperty->setValue($localResource, $trialEnd->setTimestamp($stripeResource->trialEnd));
                    break;

                case 'trialStart':
                    $trialStart = new \DateTime();
                    $reflectedProperty->setValue($localResource, $trialStart->setTimestamp($stripeResource->trialStart));
                    break;
            }
        }

        // Ever first persist the $localStripeResource: descendant syncers may require the object is known by the EntityManager.
        $this->getEntityManager()->persist($localResource);

        $this->getEntityManager()->flush();
    }

    public function syncStripeFromLocal(ApiResource $stripeResource, StripeLocalResourceInterface $localResource): void
    {
        /** @var Subscription $stripeResource */
        if ( ! $stripeResource instanceof Subscription) {
            throw new \InvalidArgumentException('SubscriptionSyncer::hydrateStripe() accepts only Stripe\Subscription objects as first parameter.');
        }

        /** @var StripeLocalSubscription $localResource */
        if ( ! $localResource instanceof StripeLocalSubscription) {
            throw new \InvalidArgumentException('SubscriptionSyncer::hydrateStripe() accepts only StripeLocalSubscription objects as second parameter.');
        }

        throw new \RuntimeException('Method not yet implemented');
    }

    public function removeLocal(StripeLocalResourceInterface $localResource): void
    {
        $this->getEntityManager()->remove($localResource);
        $this->getEntityManager()->flush();
    }
}
