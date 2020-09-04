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

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalSubscription;

/**
 * Abstract class to manage Subscriptions.
 */
abstract class AbstractStripeSubscriptionEvent extends AbstractStripeEvent
{
    /** @var StripeLocalSubscription $localSubscription */
    private $localSubscription;

    public function __construct(StripeLocalSubscription $subscription)
    {
        $this->validate($subscription);

        $this->localSubscription = $subscription;
    }

    public function getLocalSubscription(): \SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalSubscription
    {
        return $this->localSubscription;
    }

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
