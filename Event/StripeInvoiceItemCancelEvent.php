<?php

namespace SerendipityHQ\Bundle\StripeBundle\Event;

class StripeInvoiceItemCancelEvent extends AbstractStripeInvoiceItemEvent
{
    const CANCEL = 'stripe.local.invoiceitem.cancel';
    const CANCELED = 'stripe.local.invoiceitem.canceled';
    const FAILED = 'stripe.local.invoiceitem.cancel_failed';
}
