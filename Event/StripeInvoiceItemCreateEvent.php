<?php

namespace SerendipityHQ\Bundle\StripeBundle\Event;

class StripeInvoiceItemCreateEvent extends AbstractStripeInvoiceItemEvent
{
    const CREATE = 'stripe.local.invoiceitem.create';
    const CREATED = 'stripe.local.invoiceitem.created';
    const FAILED = 'stripe.local.invoiceitem.create_failed';
}
