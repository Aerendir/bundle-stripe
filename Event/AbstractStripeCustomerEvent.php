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
use Symfony\Component\EventDispatcher\Event;

/**
 * Abstract class to manage Customers.
 */
abstract class AbstractStripeCustomerEvent extends Event
{
    /** @var StripeLocalCustomer $customer */
    private $customer;

    /**
     * @param StripeLocalCustomer $customer
     */
    public function __construct(StripeLocalCustomer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return StripeLocalCustomer
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
