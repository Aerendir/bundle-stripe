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

namespace SerendipityHQ\Bundle\StripeBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalPlan;

/**
 * {@inheritdoc}
 */
class StripeLocalPlanRepository extends EntityRepository implements ByStripeIdInterface
{
    /**
     * @param $id
     *
     * @return object|StripeLocalPlan|null
     */
    public function findOneByStripeId($id)
    {
        return $this->findOneBy(['id' => mb_strtolower($id)]);
    }
}
