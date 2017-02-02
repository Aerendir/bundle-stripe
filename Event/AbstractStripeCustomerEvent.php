<?php

/*
 * This file is part of the SerendipityHQ Stripe Bundle.
 *
 * Copyright (c) Adamo Crespi <hello@aerendir.me>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Event;

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;

/**
 * Abstract class to manage Customers.
 */
abstract class AbstractStripeCustomerEvent extends AbstractStripeEvent
{
    /** @var StripeLocalCustomer $localCustomer */
    private $localCustomer;

    /**
     * @param StripeLocalCustomer $customer
     */
    public function __construct(StripeLocalCustomer $customer)
    {
        $this->localCustomer = $customer;
    }

    /**
     * @return StripeLocalCustomer
     */
    public function getLocalCustomer()
    {
        return $this->localCustomer;
    }
}
