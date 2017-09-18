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

    /** @var PlanSyncer $planSyncer */
    private $planSyncer;

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
     * @return PlanSyncer
     */
    public function getPlanSyncer()
    {
        return $this->planSyncer;
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
     * @param PlanSyncer $PlanSyncer
     */
    public function setPlanSyncer(PlanSyncer $planSyncer)
    {
        $this->planSyncer = $planSyncer;
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
        $localCustomer = $this->getEntityManager()->getRepository('SHQStripeBundle:StripeLocalCustomer')->findOneByStripeId($stripeCustomerId);

        // If we found it, return it
        if (null !== $localCustomer) {
            return $localCustomer;
        }

        // Try to find the customer in the newly created one that are not already persisted
        return $this->getEntityManager()->getUnitOfWork()->tryGetById($stripeCustomerId, StripeLocalCustomer::class);
    }
}
