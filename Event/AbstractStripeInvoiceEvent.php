<?php

namespace SerendipityHQ\Bundle\StripeBundle\Event;

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalInvoice;

/**
 * Abstract class to manage Invoices.
 */
abstract class AbstractStripeInvoiceEvent extends AbstractStripeEvent
{
    /** @var StripeLocalInvoice $localInvoice */
    private $localInvoice;

    /**
     * @param StripeLocalInvoice $invoice
     */
    public function __construct(StripeLocalInvoice $invoice)
    {
        $this->validate($invoice);

        $this->localInvoice = $invoice;
    }

    /**
     * @return StripeLocalInvoice
     */
    public function getLocalInvoice()
    {
        return $this->localInvoice;
    }

    /**
     * @param StripeLocalInvoice $invoice
     */
    private function validate(StripeLocalInvoice $invoice)
    {
        if (null === $invoice->getCustomer()) {
            throw new \InvalidArgumentException('You have to set a Customer to create a Invoice');
        }
    }
}
