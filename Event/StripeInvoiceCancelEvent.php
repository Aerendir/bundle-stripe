<?php

namespace SerendipityHQ\Bundle\StripeBundle\Event;

class StripeInvoiceCancelEvent extends AbstractStripeInvoiceEvent
{
    const CANCEL = 'stripe.local.invoice.cancel';
    const CANCELED = 'stripe.local.invoice.canceled';
    const FAILED = 'stripe.local.invoice.cancel_failed';
}
