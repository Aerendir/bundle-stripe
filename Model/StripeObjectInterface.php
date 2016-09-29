<?php

/*
 * This file is part of the SerendipityHQ Stripe Bundle.
 *
 * Copyright (c) Adamo Crespi <hello@aerendir.me>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Model;

use Stripe\ApiResource;

/**
 * An interface implemented by all Stripe Bundle models.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
interface StripeObjectInterface
{
    /**
     * @param array $data
     *
     * @return $this
     */
    public function fromArray(array $data);

    /**
     * @param ApiResource $object
     *
     * @return $this
     */
    public function fromStripeObject(ApiResource $object);

    /**
     * @return array
     */
    public function toCreate();
}
