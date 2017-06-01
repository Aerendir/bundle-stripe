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

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalInvoiceItem;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalResourceInterface;
use Stripe\ApiResource;
use Stripe\InvoiceItem;

/**
 * @see https://stripe.com/docs/api#invoice_object
 */
class InvoiceItemSyncer extends AbstractSyncer
{
    /**
     * {@inheritdoc}
     */
    public function syncLocalFromStripe(StripeLocalResourceInterface $localResource, ApiResource $stripeResource)
    {
        /** @var StripeLocalInvoiceItem $localResource */
        if (!$localResource instanceof StripeLocalInvoiceItem) {
            throw new \InvalidArgumentException('InvoiceItemSyncer::syncLocalFromStripe() accepts only StripeLocalInvoiceItem objects as first parameter.');
        }

        /** @var InvoiceItem $stripeResource */
        if (!$stripeResource instanceof InvoiceItem) {
            throw new \InvalidArgumentException('InvoiceItemSyncer::syncLocalFromStripe() accepts only Stripe\\InvoiceItem objects as second parameter.');
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
                    $reflectedProperty->setValue($localResource, $stripeResource->amount);
                    break;

                case 'description':
                    $reflectedProperty->setValue($localResource, $stripeResource->description);
                    break;

                case 'discountable':
                    $reflectedProperty->setValue($localResource, $stripeResource->discountable);
                    break;

                case 'livemode':
                    $reflectedProperty->setValue($localResource, $stripeResource->livemode);
                    break;

                case 'metadata':
                    $reflectedProperty->setValue($localResource, $stripeResource->metadata);
                    break;

                case 'period':
                    $reflectedProperty->setValue($localResource, $stripeResource->period);
                    break;

                case 'plan':
                    $reflectedProperty->setValue($localResource, $stripeResource->plan);
                    break;

                case 'proration':
                    $reflectedProperty->setValue($localResource, $stripeResource->proration);
                    break;

                case 'quantity':
                    $reflectedProperty->setValue($localResource, $stripeResource->quantity);
                    break;

                case 'subscription':
                    $reflectedProperty->setValue($localResource, $stripeResource->subscription);
                    break;

                case 'subscriptionItem':
                    $reflectedProperty->setValue($localResource, $stripeResource->subscription_item);
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
        /** @var InvoiceItem $stripeResource */
        if (!$stripeResource instanceof InvoiceItem) {
            throw new \InvalidArgumentException('InvoiceItemSyncer::hydrateStripe() accepts only Stripe\\InvoiceItem objects as first parameter.');
        }

        /** @var StripeLocalInvoiceItem $localResource */
        if (!$localResource instanceof StripeLocalInvoiceItem) {
            throw new \InvalidArgumentException('InvoiceItemSyncer::hydrateStripe() accepts only StripeLocalInvoiceItem objects as second parameter.');
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
