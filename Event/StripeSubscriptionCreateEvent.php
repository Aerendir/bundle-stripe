<?php

namespace SerendipityHQ\Bundle\StripeBundle\Event;

class StripeSubscriptionCreateEvent extends AbstractStripeSubscriptionEvent
{
    const CREATE = 'stripe.local.subscription.create';
    const CREATED = 'stripe.local.subscription.created';
    const FAILED = 'stripe.local.subscription.create_failed';
}
