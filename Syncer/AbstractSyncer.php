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

    /** @var CardSyncer $cardHydrator */
    private $cardHydrator;

    /** @var ChargeSyncer $chargeHydrator */
    private $chargeHydrator;

    /** @var CustomerSyncer $customerHydrator */
    private $customerHydrator;

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
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return CardSyncer
     */
    public function getCardSyncer()
    {
        return $this->cardHydrator;
    }

    /**
     * @return ChargeSyncer
     */
    public function getChargeSyncer()
    {
        return $this->chargeHydrator;
    }

    /**
     * @return CardSyncer
     */
    public function getCustomerSyncer()
    {
        return $this->cardHydrator;
    }

    /**
     * @param CardSyncer $cardHydrator
     */
    public function setCardSyncer(CardSyncer $cardHydrator)
    {
        $this->cardHydrator = $cardHydrator;
    }

    /**
     * @param ChargeSyncer $chargeHydrator
     */
    public function setChargeSyncer(ChargeSyncer $chargeHydrator)
    {
        $this->chargeHydrator = $chargeHydrator;
    }

    /**
     * @param CustomerSyncer $customerHydrator
     */
    public function setCustomerSyncer(CustomerSyncer $customerHydrator)
    {
        $this->customerHydrator = $customerHydrator;
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
        $localCustomer = $this->getEntityManager()->getRepository('StripeBundle:StripeLocalCustomer')->findOneBy(['stripeId' => $stripeCustomerId]);

        // If we found it, return it
        if (null !== $localCustomer) {
            return $localCustomer;
        }

        // Try to find the customer in the newly created one that are not already persisted
        return $this->getEntityManager()->getUnitOfWork()->tryGetById($stripeCustomerId, StripeLocalCustomer::class);
    }
}
