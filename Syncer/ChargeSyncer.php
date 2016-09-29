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
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalResourceInterface;
use SerendipityHQ\Component\ValueObjects\Email\Email;
use SerendipityHQ\Component\ValueObjects\Money\Money;
use Stripe\ApiResource;
use Stripe\Charge;

/**
 * @author Adamo Crespi <hello@aerendir.me>
 *
 * @see https://stripe.com/docs/api#card_object
 */
class ChargeSyncer extends AbstractSyncer
{
    /**
     * {@inheritdoc}
     */
    public  function syncLocalFromStripe(StripeLocalResourceInterface $localResource, ApiResource $stripeResource)
    {
        /** @var StripeLocalCharge $localResource */
        if (!$localResource instanceof StripeLocalCharge) {
            throw new \InvalidArgumentException('ChargeSyncer::syncLocalFromStripe() accepts only StripeLocalCharge objects as first parameter.');
        }

        /** @var Charge $stripeResource */
        if (!$stripeResource instanceof Charge) {
            throw new \InvalidArgumentException('ChargeSyncer::syncLocalFromStripe() accepts only Stripe\Charge objects as second parameter.');
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

                case 'amount':
                    $reflectedProperty->setValue($localResource, new Money(['amount' => $stripeResource->amount, 'currency' => $stripeResource->currency]));
                    break;

                case 'balanceTransaction':
                    $reflectedProperty->setValue($localResource, $stripeResource->balance_transaction);
                    break;

                case 'created':
                    $created = new \DateTime();
                    $reflectedProperty->setValue($localResource, $created->setTimestamp($stripeResource->created));
                    break;

                case 'captured':
                    $reflectedProperty->setValue($localResource, $stripeResource->captured);
                    break;

                case 'description':
                    $reflectedProperty->setValue($localResource, $stripeResource->description);
                    break;

                case 'failureCode':
                    $reflectedProperty->setValue($localResource, $stripeResource->failure_code);
                    break;

                case 'failureMessage':
                    $reflectedProperty->setValue($localResource, $stripeResource->failure_message);
                    break;

                case 'fraudDetails':
                    $reflectedProperty->setValue($localResource, $stripeResource->fraud_details);
                    break;

                case 'livemode':
                    $reflectedProperty->setValue($localResource, $stripeResource->livemode);
                    break;

                case 'metadata':
                    $reflectedProperty->setValue($localResource, $stripeResource->metadata);
                    break;

                case 'paid':
                    $reflectedProperty->setValue($localResource, $stripeResource->paid);
                    break;

                case 'receiptEmail':
                    $email = ('' === trim($stripeResource->receipt_email)) ? null : new Email($stripeResource->receipt_email);
                    $reflectedProperty->setValue($localResource, $email);
                    break;

                case 'receiptNumber':
                    $reflectedProperty->setValue($localResource, $stripeResource->receipt_number);
                    break;

                case 'statementDescriptor':
                    $reflectedProperty->setValue($localResource, $stripeResource->statement_descriptor);
                    break;

                case 'status':
                    $reflectedProperty->setValue($localResource, $stripeResource->status);
                    break;
            }
        }

        // Ever first persist the $localStripeResource: descendant syncers may require the object is known by the EntityManager.
        $this->getEntityManager()->persist($localResource);

        // Out of the foreach, process the source to associate to the charge.
        $localCard = $this->getEntityManager()->getRepository('StripeBundle:StripeLocalCard')->findOneByStripeId($stripeResource->source->id);

        // Chek if the card exists
        if (null === $localCard) {
            // It doesn't exist: create and persist it
            $localCard = new StripeLocalCard();
        }

        // Sync the local card with the remote object
        $this->getCardSyncer()->syncLocalFromStripe($localCard, $stripeResource->source);

        /*
         * Persist the card again: if it is a newly created card, we have to persist it, but, as the id of a local card
         * is its Stripe ID, we can persist it only after the sync.
         */
        $this->getEntityManager()->persist($localCard);

        // Now set the Card as source of the StripeLocalCharge object
        $defaultSourceProperty = $reflect->getProperty('source');
        $defaultSourceProperty->setAccessible(true);
        $defaultSourceProperty->setValue($localResource, $localCard);

        $this->getEntityManager()->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function syncStripeFromLocal(ApiResource $stripeResource, StripeLocalResourceInterface $localResource)
    {
        /** @var Charge $stripeResource */
        if (!$stripeResource instanceof Charge) {
            throw new \InvalidArgumentException('ChargeSyncer::hydrateStripe() accepts only Stripe\Charge objects as first parameter.');
        }

        /** @var StripeLocalCharge $localResource */
        if (!$localResource instanceof StripeLocalCharge) {
            throw new \InvalidArgumentException('ChargeSyncer::hydrateStripe() accepts only StripeLocalCharge objects as second parameter.');
        }

        throw new \RuntimeException('Method not yet implemented');
    }
}
