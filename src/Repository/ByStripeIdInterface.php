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

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalResourceInterface;

/**
 * All Interface implemented by repositories that permits to find a LocalStripeObject by their StripeId.
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
interface ByStripeIdInterface
{
    /**
     * @param $id
     *
     * @return StripeLocalResourceInterface|null
     */
    public function findOneByStripeId($id);
}
