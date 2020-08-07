<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalSubscription;

/**
 * {@inheritdoc}
 */
final class StripeLocalSubscriptionRepository extends EntityRepository implements ByStripeIdInterface
{
    /**
     * @param $id
     *
     * @return object|StripeLocalSubscription|null
     */
    public function findOneByStripeId($id): ?\SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalResourceInterface
    {
        return $this->findOneBy(['id' => \mb_strtolower($id)]);
    }
}
