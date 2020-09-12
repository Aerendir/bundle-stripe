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
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;

/**
 * An abstract class that all helpers extend.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
abstract class AbstractSyncer implements SyncerInterface
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
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
        $localCustomer =
            // First try to get the customer from the database
            $this->getEntityManager()->getRepository(StripeLocalCustomer::class)->findOneByStripeId($stripeCustomerId)
            ??
            // Try to find the customer in the newly created one that are not already persisted
            $this->getEntityManager()->getUnitOfWork()->tryGetById($stripeCustomerId, StripeLocalCustomer::class);

        if (false === $localCustomer) {
            return null;
        }

        return $localCustomer;
    }
}
