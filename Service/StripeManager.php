<?php

/*
 * This file is part of the SerendipityHQ Stripe Bundle.
 *
 * Copyright (c) Adamo Crespi <hello@aerendir.me>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Service;

use SerendipityHQ\Component\ValueObjects\Money\Money;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Error\InvalidRequest;
use Stripe\Plan;
use Stripe\Stripe;

/**
 * Manage the premium plans.
 */
class StripeManager
{
    /**
     * @param string $secretKey
     */
    public function __construct($secretKey)
    {
        Stripe::setApiKey($secretKey);
    }

    /**
     * @param $customerId
     * @param Money $amount
     *
     * @return Charge
     */
    public function chargeCustomer($customerId, Money $amount)
    {
        return Charge::create([
            'amount' => $amount->getAmount(),
            'currency' => $amount->getCurrency()->getCurrencyCode(),
            'customer' => $customerId
        ]);
    }

    /**
     * @param array $customerDetails
     *
     * @return Customer
     */
    public function createCustomer(array $customerDetails)
    {
        return Customer::create($customerDetails);
    }

    /**
     * @param $customerId
     * @param array $customerDetails
     *
     * @return Customer
     */
    public function updateCustomer($customerId, array $customerDetails)
    {
        if (false === is_string($customerId)) {
            throw new \InvalidArgumentException(
                sprintf('The StripeLocalCustomer ID has to be a string. "%s" given.', gettype($customerId))
            );
        }

        $customer = $this->getCustomer($customerId);

        // Set the new default source
        if (isset($customerDetails['source'])) {
            $customer->source = $customerDetails['source'];
        }

        // Save the customer object
        return $customer->save();
    }

    /**
     * @param $customerId
     *
     * @throws InvalidRequest
     *
     * @return bool
     */
    public function customerExists($customerId)
    {
        if (null === $customerId) {
            return false;
        }

        try {
            Customer::retrieve($customerId);
        } catch (InvalidRequest $e) {
            // Return false if the plan doesn't exist
            if (404 === $e->getHttpStatus()) {
                return false;
            }

            // For other errors throw an exception so they can be handled upper in the code execution
            throw $e;
        }

        return true;
    }

    /**
     * @param $customerId
     *
     * @throws InvalidRequest
     *
     * @return bool|null|Customer
     */
    public function getCustomer($customerId)
    {
        if (null === $customerId) {
            return false;
        }

        try {
            $customer = Customer::retrieve($customerId);
        } catch (InvalidRequest $e) {
            // Return false if the plan doesn't exist
            if (404 === $e->getHttpStatus()) {
                return;
            }

            // For other errors throw an exception so they can be handled upper in the code execution
            throw $e;
        }

        return $customer;
    }
}
