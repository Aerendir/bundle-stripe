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

namespace SerendipityHQ\Bundle\StripeBundle\Event;

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalSubscription;

/**
 * Abstract class to manage Subscriptions.
 */
abstract class AbstractStripeSubscriptionEvent extends AbstractStripeEvent
{
    /** @var StripeLocalSubscription $localSubscription */
    private $localSubscription;

    /**
     * @param StripeLocalSubscription $subscription
     */
    public function __construct(StripeLocalSubscription $subscription)
    {
        $this->validate($subscription);

        $this->localSubscription = $subscription;
    }

    /**
     * @return StripeLocalSubscription
     */
    public function getLocalSubscription()
    {
        return $this->localSubscription;
    }

    /**
     * @param StripeLocalSubscription $subscription
     */
    private function validate(StripeLocalSubscription $subscription)
    {
        if (null === $subscription->getPlan()) {
            throw new \InvalidArgumentException('You have to set a Plan to create a Subscription');
        }

        if (null === $subscription->getCustomer() && null === $subscription->getSource()) {
            throw new \InvalidArgumentException('You have to set a Customer or a Source to create a Subscription');
        }
    }
}
