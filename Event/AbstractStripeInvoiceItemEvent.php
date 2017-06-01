<?php

namespace SerendipityHQ\Bundle\StripeBundle\Event;

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalInvoiceItem;

/**
 * Abstract class to manage InvoiceItems.
 */
abstract class AbstractStripeInvoiceItemEvent extends AbstractStripeEvent
{
    /** @var StripeLocalInvoiceItem $localInvoiceItem */
    private $localInvoiceItem;

    /**
     * @param StripeLocalInvoiceItem $invoiceItem
     */
    public function __construct(StripeLocalInvoiceItem $invoiceItem)
    {
        $this->validate($invoiceItem);

        $this->localInvoiceItem = $invoiceItem;
    }

    /**
     * @return StripeLocalInvoiceItem
     */
    public function getLocalInvoiceItem()
    {
        return $this->localInvoiceItem;
    }

    /**
     * @param StripeLocalInvoiceItem $invoiceItem
     */
    private function validate(StripeLocalInvoiceItem $invoiceItem)
    {
        if (null === $invoiceItem->getCustomer()) {
            throw new \InvalidArgumentException('You have to set a Customer to create a InvoiceItem');
        }
    }
}
