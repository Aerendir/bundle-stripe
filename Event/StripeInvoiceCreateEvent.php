<?php

namespace SerendipityHQ\Bundle\StripeBundle\Event;

class StripeInvoiceCreateEvent extends AbstractStripeInvoiceEvent
{
    const CREATE = 'stripe.local.invoice.create';
    const CREATED = 'stripe.local.invoice.created';
    const FAILED = 'stripe.local.invoice.create_failed';
}
