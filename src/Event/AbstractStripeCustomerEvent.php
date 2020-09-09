<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
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

    public function __construct(StripeLocalCustomer $customer)
    {
        $this->localCustomer = $customer;
    }

    public function getLocalCustomer(): StripeLocalCustomer
    {
        return $this->localCustomer;
    }
}
