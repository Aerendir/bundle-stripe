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

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalInvoice;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalResourceInterface;
use Stripe\ApiResource;
use Stripe\Invoice;

/**
 * @see https://stripe.com/docs/api#invoice_object
 */
class InvoiceSyncer extends AbstractSyncer
{
    /**
     * {@inheritdoc}
     */
    public function syncLocalFromStripe(StripeLocalResourceInterface $localResource, ApiResource $stripeResource)
    {
        /** @var StripeLocalInvoice $localResource */
        if (!$localResource instanceof StripeLocalInvoice) {
            throw new \InvalidArgumentException('InvoiceSyncer::syncLocalFromStripe() accepts only StripeLocalInvoice objects as first parameter.');
        }

        /** @var Invoice $stripeResource */
        if (!$stripeResource instanceof Invoice) {
            throw new \InvalidArgumentException('InvoiceSyncer::syncLocalFromStripe() accepts only Stripe\\Invoice objects as second parameter.');
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

                case 'amountDue':
                    $reflectedProperty->setValue($localResource, $stripeResource->amount_due);
                    break;

                case 'applicationFee':
                    $reflectedProperty->setValue($localResource, $stripeResource->application_fee);
                    break;

                case 'attemptCount':
                    $reflectedProperty->setValue($localResource, $stripeResource->attempt_count);
                    break;

                case 'attempted':
                    $reflectedProperty->setValue($localResource, $stripeResource->attempted);
                    break;

                case 'charge':
                    $reflectedProperty->setValue($localResource, $stripeResource->charge);
                    break;

                case 'closed':
                    $reflectedProperty->setValue($localResource, $stripeResource->closed);
                    break;

                case 'date':
                    $date = new \DateTime();
                    $reflectedProperty->setValue($localResource, $date->setTimestamp($stripeResource->date));
                    break;

                case 'description':
                    $reflectedProperty->setValue($localResource, $stripeResource->description);
                    break;

                case 'endingBalance':
                    $reflectedProperty->setValue($localResource, $stripeResource->ending_balance);
                    break;

                case 'forgiven':
                    $reflectedProperty->setValue($localResource, $stripeResource->forgiven);
                    break;

                case 'livemode':
                    $reflectedProperty->setValue($localResource, $stripeResource->livemode);
                    break;

                case 'metadata':
                    $reflectedProperty->setValue($localResource, $stripeResource->metadata);
                    break;

                case 'nextPaymentAttempt':
                    $nextPaymentAttempt = new \DateTime();
                    $reflectedProperty->setValue($localResource, $nextPaymentAttempt->setTimestamp($stripeResource->next_payment_attempt));
                    break;

                case 'periodEnd':
                    $periodEnd = new \DateTime();
                    $reflectedProperty->setValue($localResource, $periodEnd->setTimestamp($stripeResource->period_end));
                    break;

                case 'periodStart':
                    $periodStart = new \DateTime();
                    $reflectedProperty->setValue($localResource, $periodStart->setTimestamp($stripeResource->period_start));
                    break;

                case 'receiptNumber':
                    $reflectedProperty->setValue($localResource, $stripeResource->receipt_number);
                    break;

                case 'startingBalance':
                    $reflectedProperty->setValue($localResource, $stripeResource->starting_balance);
                    break;

                case 'statement_descriptor':
                    $reflectedProperty->setValue($localResource, $stripeResource->statement_descriptor);
                    break;

                case 'subscription':
                    $reflectedProperty->setValue($localResource, $stripeResource->subscription);
                    break;

                case 'subscriptionProrationDate':
                    $reflectedProperty->setValue($localResource, $stripeResource->subscription_proration_date);
                    break;

                case 'subtotal':
                    $reflectedProperty->setValue($localResource, $stripeResource->subtotal);
                    break;

                case 'tax':
                    $reflectedProperty->setValue($localResource, $stripeResource->tax);
                    break;

                case 'taxPercent':
                    $reflectedProperty->setValue($localResource, $stripeResource->tax_percent);
                    break;

                case 'total':
                    $reflectedProperty->setValue($localResource, $stripeResource->total);
                    break;

                case 'webhooksDeliveredAt':
                    $webhooksDeliveredAt = new \DateTime();
                    $reflectedProperty->setValue($localResource, $webhooksDeliveredAt->setTimestamp($stripeResource->webhooks_delivered_at));
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
        /** @var Invoice $stripeResource */
        if (!$stripeResource instanceof Invoice) {
            throw new \InvalidArgumentException('InvoiceSyncer::hydrateStripe() accepts only Stripe\\Invoice objects as first parameter.');
        }

        /** @var StripeLocalInvoice $localResource */
        if (!$localResource instanceof StripeLocalInvoice) {
            throw new \InvalidArgumentException('InvoiceSyncer::hydrateStripe() accepts only StripeLocalInvoice objects as second parameter.');
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
