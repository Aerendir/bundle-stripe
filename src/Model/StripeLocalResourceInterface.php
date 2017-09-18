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

namespace SerendipityHQ\Bundle\StripeBundle\Model;

/**
 * An interface implemented by all Stripe Bundle models.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
interface StripeLocalResourceInterface
{
    /**
     * Transforms the LocalStripeResource into an array ready to be used with an ApiResource object.
     *
     * @param string $action The action to perform: create or update
     *
     * @return array
     */
    public function toStripe($action);
}
