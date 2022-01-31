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

use Doctrine\ORM\EntityManagerInterface;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCard;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalResourceInterface;
use SerendipityHQ\Component\ValueObjects\Email\Email;
use SerendipityHQ\Component\ValueObjects\Money\Money;
use SerendipityHQ\Component\ValueObjects\Money\MoneyInterface;
use Stripe\ApiResource;
use Stripe\Charge;
use Stripe\StripeObject;

/**
 * @author Adamo Crespi <hello@aerendir.me>
 *
 * @see https://stripe.com/docs/api#card_object
 */
final class ChargeSyncer extends AbstractSyncer
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
        /** @var StripeLocalCharge $localResource */
        if ( ! $localResource instanceof StripeLocalCharge) {
            throw new \InvalidArgumentException('ChargeSyncer::syncLocalFromStripe() accepts only StripeLocalCharge objects as first parameter.');
        }

        /** @var Charge $stripeResource */
        if ( ! $stripeResource instanceof Charge) {
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
                    $reflectedProperty->setValue($localResource, new Money([MoneyInterface::BASE_AMOUNT => $stripeResource->amount, MoneyInterface::CURRENCY => $stripeResource->currency]));

                    break;

                case 'amountRefunded':
                    $reflectedProperty->setValue($localResource, new Money([MoneyInterface::BASE_AMOUNT => $stripeResource->amount_refunded, MoneyInterface::CURRENCY => $stripeResource->currency]));

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
                    $fraudDetails = $stripeResource->fraud_details;

                    // If the object come from an Event is a StripeObject
                    if ($stripeResource->fraudDetails instanceof StripeObject) {
                        $fraudDetails = $fraudDetails->toArray();
                    }

                    $reflectedProperty->setValue($localResource, $fraudDetails);

                    break;

                case 'livemode':
                    $reflectedProperty->setValue($localResource, $stripeResource->livemode);

                    break;

                case 'metadata':
                    $metadata = $stripeResource->metadata;

                    // If the object come from an Event is a StripeObject
                    if ($stripeResource->metadata instanceof StripeObject) {
                        $metadata = $metadata->toArray();
                    }

                    $reflectedProperty->setValue($localResource, $metadata);

                    break;

                case 'outcome':
                    $outcome = $stripeResource->outcome;

                    // If the object come from an Event is a StripeObject
                    if ($stripeResource->outcome instanceof StripeObject) {
                        $outcome = $outcome->toArray();
                    }

                    $reflectedProperty->setValue($localResource, $outcome);

                    break;

                case 'paid':
                    $reflectedProperty->setValue($localResource, $stripeResource->paid);

                    break;

                case 'receiptEmail':
                    $email = $stripeResource->receipt_email;
                    if (\is_string($email)) {
                        $email = \trim($email);
                        $email = new Email($email);
                    }

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
        $localCard = $this->getEntityManager()->getRepository(StripeLocalCard::class)->findOneByStripeId($stripeResource->source->id);

        // Check if the card exists
        /**
         * Fails on:
         * - PHP7.3, --prefer-stable --prefer-lowest, SF~4.4
         * - PHP7.3, --prefer-stable --prefer-lowest, SF~5.2
         * - PHP7.4, --prefer-stable --prefer-lowest, SF~4.4
         * - PHP7.4, --prefer-stable --prefer-lowest, SF~5.2.
         *
         * @psalm-suppress DocblockTypeContradiction
         */
        if (null === $localCard) {
            // It doesn't exist: create and persist it
            $localCard = new StripeLocalCard();
        }

        // Sync the local card with the remote object
        /**
         * Fails on:
         * - PHP7.3, --prefer-stable --prefer-lowest, SF~4.4
         * - PHP7.3, --prefer-stable --prefer-lowest, SF~5.2
         * - PHP7.4, --prefer-stable --prefer-lowest, SF~4.4
         * - PHP7.4, --prefer-stable --prefer-lowest, SF~5.2.
         *
         * @psalm-suppress InvalidArgument
         */
        $this->cardSyncer->syncLocalFromStripe($localCard, $stripeResource->source);

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

    public function syncStripeFromLocal(ApiResource $stripeResource, StripeLocalResourceInterface $localResource): void
    {
        /** @var Charge $stripeResource */
        if ( ! $stripeResource instanceof Charge) {
            throw new \InvalidArgumentException('ChargeSyncer::hydrateStripe() accepts only Stripe\Charge objects as first parameter.');
        }

        /** @var StripeLocalCharge $localResource */
        if ( ! $localResource instanceof StripeLocalCharge) {
            throw new \InvalidArgumentException('ChargeSyncer::hydrateStripe() accepts only StripeLocalCharge objects as second parameter.');
        }

        throw new \RuntimeException('Method not yet implemented');
    }

    public function handleFraudDetection(StripeLocalCharge $localCharge, array $error): void
    {
        $reflect = new \ReflectionClass($localCharge);

        // Set the Charge Stripe ID as returned by the error
        $propertyId = $reflect->getProperty('id');
        $propertyId->setAccessible(true);
        $propertyId->setValue($localCharge, $error['error']['charge']);

        // Set other required fields. They will be update with right data by the webhook calling
        $propertyCaptured = $reflect->getProperty('captured');
        $propertyCaptured->setAccessible(true);
        $propertyCaptured->setValue($localCharge, false);

        $propertyCreated = $reflect->getProperty('created');
        $propertyCreated->setAccessible(true);
        // Set fictionally
        $propertyCreated->setValue($localCharge, new \DateTime());

        $propertyLivemode = $reflect->getProperty('livemode');
        $propertyLivemode->setAccessible(true);
        $propertyLivemode->setValue($localCharge, true);

        $propertyPaid = $reflect->getProperty('paid');
        $propertyPaid->setAccessible(true);
        $propertyPaid->setValue($localCharge, false);

        // Mark the card as fraudulent
        $localCharge->getCustomer()->getDefaultSource()->setError($error['concatenated']);

        // Save the local charge to the database
        $this->getEntityManager()->persist($localCharge);
        $this->getEntityManager()->flush();
    }
}
