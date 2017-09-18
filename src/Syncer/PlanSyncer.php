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

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalPlan;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalResourceInterface;
use SerendipityHQ\Component\ValueObjects\Money\Money;
use Stripe\ApiResource;
use Stripe\Plan;

/**
 * @see https://stripe.com/docs/api#plan_object
 */
class PlanSyncer extends AbstractSyncer
{
    /**
     * {@inheritdoc}
     */
    public function syncLocalFromStripe(StripeLocalResourceInterface $localResource, ApiResource $stripeResource)
    {
        /** @var StripeLocalPlan $localResource */
        if ( ! $localResource instanceof StripeLocalPlan) {
            throw new \InvalidArgumentException('PlanSyncer::syncLocalFromStripe() accepts only StripeLocalPlan objects as first parameter.');
        }

        /** @var Plan $stripeResource */
        if ( ! $stripeResource instanceof Plan) {
            throw new \InvalidArgumentException('PlanSyncer::syncLocalFromStripe() accepts only Stripe\Plan objects as second parameter.');
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

                case 'object':
                    $reflectedProperty->setValue($localResource, $stripeResource->object);
                    break;

                case 'amount':
                    $reflectedProperty->setValue($localResource, new Money(['amount' => $stripeResource->amount, 'currency' => $stripeResource->currency]));
                    break;

                case 'created':
                    $created = new \DateTime();
                    $reflectedProperty->setValue($localResource, $created->setTimestamp($stripeResource->created));
                    break;

                case 'interval':
                    $reflectedProperty->setValue($localResource, $stripeResource->interval);
                    break;

                case 'intervalCount':
                    $reflectedProperty->setValue($localResource, $stripeResource->interval_count);
                    break;

                case 'livemode':
                    $reflectedProperty->setValue($localResource, $stripeResource->livemode);
                    break;

                case 'metadata':
                    $reflectedProperty->setValue($localResource, $stripeResource->metadata);
                    break;

                case 'name':
                    $reflectedProperty->setValue($localResource, $stripeResource->name);
                    break;

                case 'statementDescriptor':
                    $reflectedProperty->setValue($localResource, $stripeResource->statement_descriptor);
                    break;

                case 'trialPeriodDays':
                    $reflectedProperty->setValue($localResource, $stripeResource->trial_period_days);
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
        /** @var Plan $stripeResource */
        if ( ! $stripeResource instanceof Plan) {
            throw new \InvalidArgumentException('PlanSyncer::hydrateStripe() accepts only Stripe\Plan objects as first parameter.');
        }

        /** @var StripeLocalPlan $localResource */
        if ( ! $localResource instanceof StripeLocalPlan) {
            throw new \InvalidArgumentException('PlanSyncer::hydrateStripe() accepts only StripeLocalPlan objects as second parameter.');
        }

        $this->getEntityManager()->persist($localResource);
        $this->getEntityManager()->flush();
    }

    /**
     * @param StripeLocalResourceInterface $localResource
     * @param ApiResource                  $stripeResource
     */
    public function syncLocalSources(StripeLocalResourceInterface $localResource, ApiResource $stripeResource)
    {
        /** @var StripeLocalPlan $localResource */
        if ( ! $localResource instanceof StripeLocalPlan) {
            throw new \InvalidArgumentException('PlanSyncer::syncLocalFromStripe() accepts only StripeLocalPlan objects as first parameter.');
        }

        /** @var Plan $stripeResource */
        if ( ! $stripeResource instanceof Plan) {
            throw new \InvalidArgumentException('PlanSyncer::syncLocalFromStripe() accepts only Stripe\Plan objects as second parameter.');
        }

        $this->getEntityManager()->persist($localResource);
        $this->getEntityManager()->flush();
    }
}
