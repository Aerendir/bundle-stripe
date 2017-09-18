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

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCard;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalResourceInterface;
use Stripe\ApiResource;
use Stripe\Card;

/**
 * @author Adamo Crespi <hello@aerendir.me>
 *
 * @see https://stripe.com/docs/api#card_object
 */
class CardSyncer extends AbstractSyncer
{
    /**
     * {@inheritdoc}
     *
     * @param Card $stripeResource
     */
    public function syncLocalFromStripe(StripeLocalResourceInterface $localResource, ApiResource $stripeResource)
    {
        /** @var StripeLocalCard $localResource */
        if ( ! $localResource instanceof StripeLocalCard) {
            throw new \InvalidArgumentException('CardSyncer::hydrateLocal() accepts only StripeLocalCard objects as first parameter');
        }

        /** @var Card $stripeResource */
        if ( ! $stripeResource instanceof Card) {
            throw new \InvalidArgumentException('CardSyncer::hydrateLocal() accepts only Stripe\Card objects as second parameter.');
        }

        $reflect = new \ReflectionClass($localResource);

        foreach ($reflect->getProperties() as $reflectedProperty) {
            // Set the property as accessible
            $reflectedProperty->setAccessible(true);

            /*
             * Guess the kind and set its value (Customer has to be StripeLocalCustomerObject set before the Card
             * $localResource is passed to this hydration method!)
             */
            switch ($reflectedProperty->getName()) {
                case 'id':
                    $reflectedProperty->setValue($localResource, $stripeResource->id);
                    break;

                case 'addressCity':
                    $reflectedProperty->setValue($localResource, $stripeResource->address_city);
                    break;

                case 'addressCountry':
                    $reflectedProperty->setValue($localResource, $stripeResource->address_country);
                    break;

                case 'addressLine1':
                    $reflectedProperty->setValue($localResource, $stripeResource->address_line1);
                    break;

                case 'addressLine1Check':
                    $reflectedProperty->setValue($localResource, $stripeResource->address_line1_check);
                    break;

                case 'addressLine2':
                    $reflectedProperty->setValue($localResource, $stripeResource->address_line2);
                    break;

                case 'addressState':
                    $reflectedProperty->setValue($localResource, $stripeResource->address_state);
                    break;

                case 'addressZip':
                    $reflectedProperty->setValue($localResource, $stripeResource->address_zip);
                    break;

                case 'addressZipCheck':
                    $reflectedProperty->setValue($localResource, $stripeResource->address_zip_check);
                    break;

                case 'brand':
                    $reflectedProperty->setValue($localResource, $stripeResource->brand);
                    break;

                case 'country':
                    $reflectedProperty->setValue($localResource, $stripeResource->country);
                    break;

                case 'customer':
                    $localCustomer = $this->getLocalCustomer($stripeResource->customer);

                    if (false !== $localCustomer) {
                        $reflectedProperty->setValue($localResource, $localCustomer);
                    }
                    break;

                case 'cvcCheck':
                    $reflectedProperty->setValue($localResource, $stripeResource->cvc_check);
                    break;

                case 'dynamicLast4':
                    $reflectedProperty->setValue($localResource, $stripeResource->dynamic_last4);
                    break;

                case 'expMonth':
                    $reflectedProperty->setValue($localResource, $stripeResource->exp_month);
                    break;

                case 'expYear':
                    $reflectedProperty->setValue($localResource, $stripeResource->exp_year);
                    break;

                case 'fingerprint':
                    $reflectedProperty->setValue($localResource, $stripeResource->fingerprint);
                    break;

                case 'funding':
                    $reflectedProperty->setValue($localResource, $stripeResource->funding);
                    break;

                case 'last4':
                    $reflectedProperty->setValue($localResource, $stripeResource->last4);
                    break;

                case 'metadata':
                    $reflectedProperty->setValue($localResource, $stripeResource->metadata->__toArray());
                    break;

                case 'name':
                    $reflectedProperty->setValue($localResource, $stripeResource->name);
                    break;

                case 'tokenizationMethod':
                    $reflectedProperty->setValue($localResource, $stripeResource->tokenization_method);
                    break;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function syncStripeFromLocal(ApiResource $stripeResource, StripeLocalResourceInterface $localResource)
    {
        /** @var Card $stripeResource */
        if ( ! $stripeResource instanceof Card) {
            throw new \InvalidArgumentException('CardSyncer::hydrateLocal() accepts only Stripe\Card objects as first parameter.');
        }

        /** @var StripeLocalCard $localResource */
        if ( ! $localResource instanceof StripeLocalCard) {
            throw new \InvalidArgumentException('CardSyncer::hydrateLocal() accepts only StripeLocalCard objects as second parameter.');
        }

        throw new \RuntimeException('Method not yet implemented');
    }
}
