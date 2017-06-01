<?php

namespace SerendipityHQ\Bundle\StripeBundle\Event;

class StripeInvoicePayEvent extends AbstractStripeInvoiceEvent
{
    const PAY = 'stripe.local.invoice.pay';
    const PAYED = 'stripe.local.invoice.payed';
    const FAILED = 'stripe.local.invoice.pay_failed';
}
