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

namespace SerendipityHQ\Bundle\StripeBundle\Syncer;

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalResourceInterface;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalSubscription;
use Stripe\ApiResource;
use Stripe\Subscription;

/**
 * @see https://stripe.com/docs/api#subscription_object
 */
class SubscriptionSyncer extends AbstractSyncer
{
    /**
     * {@inheritdoc}
     */
    public function syncLocalFromStripe(StripeLocalResourceInterface $localResource, ApiResource $stripeResource)
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
                    $reflectedProperty->setValue($localResource, $stripeResource->application_fee_percent);
                    break;

                case 'cancelAtPeriodEnd':
                    $reflectedProperty->setValue($localResource, $stripeResource->cancel_at_period_at);
                    break;

                case 'canceledAt':
                    $reflectedProperty->setValue($localResource, $stripeResource->canceled_at);
                    break;

                case 'created':
                    $created = new \DateTime();
                    $reflectedProperty->setValue($localResource, $created->setTimestamp($stripeResource->created));
                    break;

                case 'currentPeriodEnd':
                    $currentPeriodEnd = new \DateTime();
                    $reflectedProperty->setValue($localResource, $currentPeriodEnd->setTimestamp($stripeResource->current_period_end));
                    break;

                case 'currentPeriodStart':
                    $currentPeriodStart = new \DateTime();
                    $reflectedProperty->setValue($localResource, $currentPeriodStart->setTimestamp($stripeResource->current_period_start));
                    break;

                case 'discount':
                    $reflectedProperty->setValue($localResource, $stripeResource->discount);
                    break;

                case 'endedAt':
                    $endedAt = new \DateTime();
                    $reflectedProperty->setValue($localResource, $endedAt->setTimestamp($stripeResource->ended_at));
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
                    $reflectedProperty->setValue($localResource, $stripeResource->tax_percent);
                    break;

                case 'trialEnd':
                    $trialEnd = new \DateTime();
                    $reflectedProperty->setValue($localResource, $trialEnd->setTimestamp($stripeResource->trial_end));
                    break;

                case 'trialStart':
                    $trialStart = new \DateTime();
                    $reflectedProperty->setValue($localResource, $trialStart->setTimestamp($stripeResource->trial_start));
                    break;
            }
        }

        // Ever first persist the $localStripeResource: descendant syncers may require the object is known by the EntityManager.
        $this->getEntityManager()->persist($localResource);

        $this->getEntityManager()->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function syncStripeFromLocal(ApiResource $stripeResource, StripeLocalResourceInterface $localResource)
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

    /**
     * {@inheritdoc}
     */
    public function removeLocal(StripeLocalResourceInterface $localResource)
    {
        $this->getEntityManager()->remove($localResource);
        $this->getEntityManager()->flush();
    }
}
