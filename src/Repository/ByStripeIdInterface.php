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

namespace SerendipityHQ\Bundle\StripeBundle\Repository;

/**
 * All Interface implemented by repositories that permits to find a LocalStripeObject by their StripeId.
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
interface ByStripeIdInterface
{
    /**
     * @param $id
     */
    public function findOneByStripeId($id): ?\SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalResourceInterface;
}
