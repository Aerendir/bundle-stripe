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

use Doctrine\ORM\EntityManager;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;

/**
 * An abstract class that all helpers extend.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
abstract class AbstractSyncer implements SyncerInterface
{
    /** @var EntityManager $entityManager */
    private $entityManager;

    /** @var CardSyncer $cardSyncer */
    private $cardSyncer;

    /** @var ChargeSyncer $chargeSyncer */
    private $chargeSyncer;

    /** @var SubscriptionSyncer $subscriptionSyncer */
    private $subscriptionSyncer;

    /** @var CustomerSyncer $customerSyncer */
    private $customerSyncer;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @return CardSyncer
     */
    public function getCardSyncer(): CardSyncer
    {
        return $this->cardSyncer;
    }

    /**
     * @return ChargeSyncer
     */
    public function getChargeSyncer(): ChargeSyncer
    {
        return $this->chargeSyncer;
    }

    /**
     * @return SubscriptionSyncer
     */
    public function getSubscriptionSyncer(): SubscriptionSyncer
    {
        return $this->subscriptionSyncer;
    }

    /**
     * @return CustomerSyncer
     */
    public function getCustomerSyncer(): CustomerSyncer
    {
        return $this->customerSyncer;
    }

    /**
     * @param CardSyncer $cardSyncer
     */
    public function setCardSyncer(CardSyncer $cardSyncer)
    {
        $this->cardSyncer = $cardSyncer;
    }

    /**
     * @param ChargeSyncer $chargeSyncer
     */
    public function setChargeSyncer(ChargeSyncer $chargeSyncer)
    {
        $this->chargeSyncer = $chargeSyncer;
    }

    /**
     * @param SubscriptionSyncer $subscriptionSyncer
     */
    public function setSubscriptionSyncer(SubscriptionSyncer $subscriptionSyncer)
    {
        $this->subscriptionSyncer = $subscriptionSyncer;
    }

    /**
     * @param CustomerSyncer $customerSyncer
     */
    public function setCustomerSyncer(CustomerSyncer $customerSyncer)
    {
        $this->customerSyncer = $customerSyncer;
    }

    /**
     * Gets the local customer object searching for it in the database or in the newly created entities persisted but
     * not yet flushed.
     *
     * @param $stripeCustomerId
     *
     * @return bool|StripeLocalCustomer false if the StripeLocalCustomer was not found
     */
    protected function getLocalCustomer($stripeCustomerId)
    {
        // First try to get the customer from the database
        $localCustomer = $this->getEntityManager()->getRepository('StripeBundle:StripeLocalCustomer')->findOneByStripeId($stripeCustomerId);

        // If we found it, return it
        if (null !== $localCustomer) {
            return $localCustomer;
        }

        // Try to find the customer in the newly created one that are not already persisted
        return $this->getEntityManager()->getUnitOfWork()->tryGetById($stripeCustomerId, StripeLocalCustomer::class);
    }
}
