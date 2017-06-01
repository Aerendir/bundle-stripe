<?php

namespace SerendipityHQ\Bundle\StripeBundle\Model;

use SerendipityHQ\Component\ValueObjects\Money\Money;

/**
 * @see https://stripe.com/docs/api#invoiceitem_object
 */
class StripeLocalInvoiceItem implements StripeLocalResourceInterface
{
    /** @var string The Stripe ID of the StripeLocalInvoiceItem */
    private $id;

    /**
     * @var string
     *
     * String representing the object’s type. Objects of the same type share the same value.
     *
     * @see https://stripe.com/docs/api/curl#invoiceitem_object-object
     */
    private $object;

    /**
     * @var int
     *
     * Amount (in the currency specified) of the invoice item
     *
     * @see https://stripe.com/docs/api/curl#invoiceitem_object-amount
     */
    private $amount;

    /**
     * @var currency
     *
     * Three-letter ISO currency code, in lowercase. Must be a supported currency.
     *
     * @see https://stripe.com/docs/api/curl#invoiceitem_object-currency
     */
    private $currency;

    /**
     * @var StripeLocalCustomer
     *
     * ID of the customer this charge is for if one exists
     *
     * @see  https://stripe.com/docs/api/php#charge_object-customer
     */
    private $customer;

    /**
     * @var \DateTime
     *
     * @see https://stripe.com/docs/api/curl#invoiceitem_object-date
     */
    private $date;

    /**
     * @var string
     *
     * An arbitrary string attached to the object. Often useful for displaying to users.
     *
     * @see https://stripe.com/docs/api/curl#invoiceitem_object-description
     */
    private $description;

    /**
     * @var bool
     *
     * If true, discounts will apply to this invoice item. Always false for prorations.
     *
     * @see https://stripe.com/docs/api/curl#invoiceitem_object-discountable
     */
    private $discountable;

    /**
     * @var string
     *
     * The ID of the invoice this invoice item belongs to
     *
     * @see https://stripe.com/docs/api/curl#invoiceitem_object-invoice
     */
    private $invoice;

    /** @var bool */
    private $livemode;

    /** @var string
     * A set of key/value pairs that you can attach to a charge object. It can be useful for storing additional
     * information about the charge in a structured format.
     *
     * @see https://stripe.com/docs/api#invoiceitem_object-metadata
     */
    private $metadata;

    /** @var string
     * @see https://stripe.com/docs/api/curl#invoiceitem_object-period
     */
    private $period;

    /**
     * @var string
     *
     * If the invoice item is a proration, the plan of the subscription that the proration was computed for
     *
     * @see https://stripe.com/docs/api#invoiceitem_object-plan
     */
    private $plan;

    /**
     * @var bool
     *
     * Whether or not the invoice item was created automatically as a proration adjustment when the customer switched
     * plans
     *
     * @see https://stripe.com/docs/api/curl#invoiceitem_object-proration
     */
    private $proration;

    /**
     * @var int
     *
     * If the invoice item is a proration, the quantity of the subscription that the proration was computed for
     *
     * @see https://stripe.com/docs/api/curl#invoiceitem_object-quantity
     */
    private $quantity;

    /**
     * @var string
     *
     * The subscription that this invoice item has been created for, if any
     *
     * @see https://stripe.com/docs/api/curl#invoiceitem_object-subscription
     */
    private $subscription;

    /**
     * @var string
     *
     * @see https://stripe.com/docs/api/curl#invoiceitem_object-subscription_item
     */
    private $subscriptionItem;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return StripeLocalCustomer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isDiscountable()
    {
        return $this->discountable;
    }

    /**
     * @return string
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * @return bool
     */
    public function isLivemode()
    {
        return $this->livemode;
    }

    /**
     * @return string
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return string
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @return string
     */
    public function getProration()
    {
        return $this->proration;
    }

    /**
     * @return string
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @return bool
     */
    public function isProration()
    {
        return $this->proration;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @return string
     */
    public function getSubscriptionItem()
    {
        return $this->subscriptionItem;
    }

    /**
     * @param string $object
     *
     * @return StripeLocalInvoiceItem
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * This sets the amount only if it is null.
     *
     * This is to prevent an accidental overwriting of it.
     *
     * @param Money $amount
     *
     * @throws \InvalidArgumentException If the amount is not an integer
     *
     * @return StripeLocalCharge
     */
    public function setAmount(Money $amount)
    {
        if (null === $this->amount) {
            $this->amount = $amount;
        }

        return $this;
    }

    /**
     * @param StripeLocalCustomer $customer
     *
     * @return StripeLocalInvoiceItem
     */
    public function setCustomer(StripeLocalCustomer $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @param \DateTime $date
     *
     * @return StripeLocalInvoiceItem
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return StripeLocalInvoiceItem
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this->description;
    }

    /**
     * @param string $invoice
     *
     * @return StripeLocalInvoiceItem
     */
    public function setInvoice($invoice)
    {
        return $this->invoice;
    }

    /**
     * @param string|array $metadata
     *
     * @return StripeLocalInvoiceItem
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @param string $period
     *
     * @return StripeLocalInvoiceItem
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * @param string $proration
     *
     * @return StripeLocalInvoiceItem
     */
    public function setProration($proration)
    {
        $this->proration = $proration;

        return $this;
    }

    /**
     * @param string $plan
     *
     * @return StripeLocalInvoiceItem
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * @param int $quantity
     *
     * @return StripeLocalInvoiceItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @param string $subscription
     *
     * @return StripeLocalInvoiceItem
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;

        return $this;
    }

    /**
     * @param string $subscriptionItem
     *
     * @return StripeLocalInvoiceItem
     */
    public function setSubscriptionItem($subscriptionItem)
    {
        $this->subscriptionItem = $subscriptionItem;

        return $this;
    }

    /**
     * Transforms metadata from string to array.
     *
     * As metadata can be set by the developer or by reflection during syncronization of the StripeCustomer object with
     * this local one, may happen the value is a string.
     *
     * This lifecycle callback ensures the value ever is an array.
     */
    public function metadataTransformer()
    {
        if (is_string($this->getMetadata())) {
            $this->setMetadata(json_decode($this->getMetadata(), true));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function toStripe($action)
    {
        $return = [];

        // Prepare the array for creation
        if ('create' === $action) {
            /*
             * This checks an amount is set.
             *
             * As the amount is a Money object, if it exists, also a Currency exists.
             */
            if (null === $this->getAmount()) {
                throw new \InvalidArgumentException('To create a InvoiceItem you need to set an Amount.');
            }

            /*
             * This checks a customer.
             */
            if (null === $this->getCustomer()) {
                throw new \InvalidArgumentException('To create a InvoiceItem you need to set an Customer.');
            }

            $return = [
                'amount' => $this->getAmount()->getAmount(),
                'currency' => $this->getAmount()->getCurrency()->getCurrencyCode(),
            ];

            /*
             * customer required
             *
             * The ID of the customer who will be billed when this invoice item is billed.
             *
             * @see https://stripe.com/docs/api/curl#create_invoiceitem-currency
             */
            if (null !== $this->getCustomer()->getId()) {
                $return['customer'] = $this->getCustomer()->getId();
            }

            /*
             * description optional
             *
             * An arbitrary string which you can attach to the invoice item. The description is displayed in the invoice
             * for easy tracking. This will be unset if you POST an empty value.
             *
             * @see https://stripe.com/docs/api/curl#create_invoiceitem-description
             */
            if (null !== $this->getDescription()) {
                $return['description'] = $this->getDescription();
            }

            /*
             * discountable optional
             *
             * Controls whether discounts apply to this invoice item. Defaults to false for prorations or negative
             * invoice items, and true for all other invoice items.
             *
             * @see https://stripe.com/docs/api/curl#create_invoiceitem-discountable
             */
            if (null !== $this->isDiscountable()) {
                $return['discountable'] = $this->isDiscountable();
            }

            /*
             * invoice optional
             *
             * The ID of an existing invoice to add this invoice item to. When left blank, the invoice item will be
             * added to the next upcoming scheduled invoice. Use this when adding invoice items in response to an
             * invoice.created webhook. You cannot add an invoice item to an invoice that has already been paid,
             * attempted or closed.
             *
             * @see https://stripe.com/docs/api/curl#create_invoiceitem-invoice
             */
            if (null !== $this->getInvoice()) {
                $return['invoice'] = $this->getInvoice();
            }

            /*
             * metadata optional, default is { }.
             *
             * A set of key/value pairs that you can attach to a charge object. It can be useful for storing additional
             * information about the customer in a structured format. It's often a good idea to store an email address
             * in metadata for tracking later.
             *
             * @see https://stripe.com/docs/api/php#create_charge-metadata
             */
            if (null !== $this->getMetadata()) {
                $return['metadata'] = $this->getMetadata();
            }

            /*
             * receipt_email optional, default is null.
             *
             * The ID of a subscription to add this invoice item to. When left blank, the invoice item will be be added
             * to the next upcoming scheduled invoice. When set, scheduled invoices for subscriptions other than the
             * specified subscription will ignore the invoice item. Use this when you want to express that an invoice
             * item has been accrued within the context of a particular subscription.
             *
             * @see https://stripe.com/docs/api/curl#create_invoiceitem-subscription
             */
            if (null !== $this->getSubscription()) {
                $return['subscription'] = $this->getSubscription();
            }
        }

        return $return;
    }
}
