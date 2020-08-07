<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
     */
    public function toStripe(string $action): array;
}
