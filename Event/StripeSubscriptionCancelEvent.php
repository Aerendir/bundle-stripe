<?php

namespace SerendipityHQ\Bundle\StripeBundle\Event;

class StripeSubscriptionCancelEvent extends AbstractStripeSubscriptionEvent
{
    const CANCEL = 'stripe.local.subscription.cancel';
    const CANCELED = 'stripe.local.subscription.canceled';
    const FAILED = 'stripe.local.subscription.cancel_failed';
}
