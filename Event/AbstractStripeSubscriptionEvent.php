<?php

namespace SerendipityHQ\Bundle\StripeBundle\Event;

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalSubscription;
use Symfony\Component\EventDispatcher\Event;

/**
 * Abstract class to manage Subscriptions.
 */
abstract class AbstractStripeSubscriptionEvent extends Event
{
    /** @var StripeLocalSubscription $localSubscription */
    private $localSubscription;

    /**
     * @param StripeLocalSubscription $charge
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
