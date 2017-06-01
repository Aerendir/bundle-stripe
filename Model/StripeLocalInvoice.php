<?php

namespace SerendipityHQ\Bundle\StripeBundle\Model;

/**
 * @see https://stripe.com/docs/api#invoice_object
 */
class StripeLocalInvoice implements StripeLocalResourceInterface
{
    /** @var string The Stripe ID of the StripeLocalInvoice */
    private $id;

    /**
     * @var string
     *
     * String representing the object’s type. Objects of the same type share the same value.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-object
     */
    private $object;

    /**
     * @var int
     *
     * Final amount due at this time for this invoice. If the invoice’s total is smaller than the minimum charge amount,
     * for example, or if there is account credit that can be applied to the invoice, the amount_due may be 0. If there
     * is a positive starting_balance for the invoice (the customer owes money), the amount_due will also take that into
     * account. The charge that gets generated for the invoice will be for the amount specified in amount_due.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-amount_due
     */
    private $amountDue;

    /**
     * @var int
     *
     * The fee in cents that will be applied to the invoice and transferred to the application owner’s Stripe account
     * when the invoice is paid.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-application_fee
     */
    private $applicationFee;

    /**
     * @var int
     *
     * Number of payment attempts made for this invoice, from the perspective of the payment retry schedule. Any payment
     * attempt counts as the first attempt, and subsequently only automatic retries increment the attempt count. In
     * other words, manual payment attempts after the first attempt do not affect the retry schedule.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-attempt_count
     */
    private $attemptCount;

    /**
     * @var bool
     *
     * Whether or not an attempt has been made to pay the invoice. An invoice is not attempted until 1 hour after the
     * invoice.created webhook, for example, so you might not want to display that invoice as unpaid to your users.
     *
     * @see https://stripe.com/docs/api#invoice_object-cancel_at_period_end
     */
    private $attempted;

    /**
     * @var string
     *
     * ID of the latest charge generated for this invoice, if any.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-charge
     */
    private $charge;

    /**
     * @var boolean
     *
     * ID of the latest charge generated for this invoice, if any.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-closed
     */
    private $closed;

    /**
     * @var currency
     *
     * Three-letter ISO currency code, in lowercase. Must be a supported currency.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-currency
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
     * Time at which the object was created. Measured in seconds since the Unix epoch.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-date
     */
    private $date;

    /**
     * @var string
     *
     * An arbitrary string attached to the object. Often useful for displaying to users.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-description
     */
    private $description;

    /**
     * @var string discountObject optional, default is null
     *
     * @see https://stripe.com/docs/api#discount_object
     *
     * Describes the current discount applied to this invoice, if there is one. When billing, a discount applied to
     * a invoice overrides a discount applied on a customer-wide basis.
     * @see https://stripe.com/docs/api#invoice_object-discount
     */
    private $discount;

    /**
     * @var int
     *
     * Ending customer balance after attempting to pay invoice. If the invoice has not been attempted yet, this will be
     * null.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-ending_balance
     */
    private $endingBalance;

    /**
     * @var boolean
     *
     * Whether or not the invoice has been forgiven. Forgiving an invoice instructs us to update the subscription status
     * as if the invoice were successfully paid. Once an invoice has been forgiven, it cannot be unforgiven or reopened.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-forgiven
     */
    private $forgiven;

    /**
     * @var list
     *
     * The individual line items that make up the invoice. lines is sorted as follows: invoice items in reverse
     * chronological order, followed by the subscription, if any.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-lines
     */
    private $lines;

    /** @var bool */
    private $livemode;

    /** @var string
     * A set of key/value pairs that you can attach to a charge object. It can be useful for storing additional
     * information about the charge in a structured format.
     *
     * @see https://stripe.com/docs/api#invoice_object-metadata
     */
    private $metadata;

    /**
     * @var \DateTime
     *
     * The time at which payment will next be attempted.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-next_payment_attempt
     */
    private $nextPaymentAttempt;

    /**
     * @var boolean
     *
     * Whether or not payment was successfully collected for this invoice. An invoice can be paid (most commonly) with a
     * charge or with credit from the customer’s account balance.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-paid
     */
    private $paid;


    /**
     * @var \DateTime
     *
     * End of the usage period during which invoice items were added to this invoice.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-period_end
     */
    private $periodEnd;

    /**
     * @var \DateTime
     *
     * Start of the usage period during which invoice items were added to this invoice.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-period_start
     */
    private $periodStart;

    /**
     * @var string
     *
     * This is the transaction number that appears on email receipts sent for this invoice.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-receipt_number
     */
    private $receiptNumber;

    /**
     * @var int
     *
     * Starting customer balance before attempting to pay invoice. If the invoice has not been attempted yet, this will
     * be the current customer balance.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-receipt_number
     */
    private $startingBalance;

    /**
     * @var string
     *
     * Extra information about an invoice for the customer’s credit card statement.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-statement_descriptor
     */
    private $statementDescriptor;

    /**
     * @var string
     *
     * The subscription that this invoice was prepared for, if any.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-subscription
     */
    private $subscription;

    /**
     * @var int
     *
     * Only set for upcoming invoices that preview prorations. The time used to calculate prorations.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-subscription_proration_date
     */
    private $subscriptionProrationDate;

    /**
     * @var int
     *
     * Total of all subscriptions, invoice items, and prorations on the invoice before any discount is applied.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-subtotal
     */
    private $subtotal;

    /**
     * @var int
     *
     * The amount of tax included in the total, calculated from tax_percent and the subtotal. If no tax_percent is
     * defined, this value will be null.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-tax
     */
    private $tax;

    /**
     * @var float
     *
     * This percentage of the subtotal has been added to the total amount of the invoice, including invoice line items
     * and discounts. This field is inherited from the subscription’s tax_percent field, but can be changed before the
     * invoice is paid. This field defaults to null.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-tax_percent
     */
    private $taxPercent;

    /**
     * @var int
     *
     * Total after discount.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-total
     */
    private $total;

    /**
     * @var \DateTime
     *
     * The time at which webhooks for this invoice were successfully delivered (if the invoice had no webhooks to
     * deliver, this will match date). Invoice payment is delayed until webhooks are delivered, or until all webhook
     * delivery attempts have been exhausted.
     *
     * @see https://stripe.com/docs/api/curl#invoice_object-webhooks_delivered_at
     */
    private $webhooksDeliveredAt;

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
    public function getAmountDue()
    {
        return $this->amountDue;
    }

    /**
     * @return int
     */
    public function getApplicationFee()
    {
        return $this->applicationFee;
    }

    /**
     * @return int
     */
    public function getAttemptCount()
    {
        return $this->attemptCount;
    }

    /**
     * @return bool
     */
    public function isAttempted()
    {
        return $this->attempted;
    }

    /**
     * @return string
     */
    public function getCharge()
    {
        return $this->charge;
    }

    /**
     * @return bool
     */
    public function isClosed()
    {
        return $this->closed;
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
     * @return null|string
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @return int
     */
    public function getEndingBalance()
    {
        return $this->endingBalance;
    }

    /**
     * @return bool
     */
    public function isForgiven()
    {
        return $this->forgiven;
    }

    /**
     * @return list
     */
    public function getLines()
    {
        return $this->lines;
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
     * @return \DateTime
     */
    public function getNextPaymentAttempt()
    {
        return $this->nextPaymentAttempt;
    }

    /**
     * @return bool
     */
    public function isPaid()
    {
        return $this->paid;
    }

    /**
     * @return \DateTime
     */
    public function getPeriodEnd()
    {
        return $this->periodEnd;
    }

    /**
     * @return \DateTime
     */
    public function getPeriodStart()
    {
        return $this->periodStart;
    }

    /**
     * @return string
     */
    public function getReceiptNumber()
    {
        return $this->receiptNumber;
    }

    /**
     * @return int
     */
    public function getStartingBalance()
    {
        return $this->startingBalance;
    }

    /**
     * @return string
     */
    public function getStatementDescriptor()
    {
        return $this->statementDescriptor;
    }

    /**
     * @return string
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @return \DateTime
     */
    public function getSubscriptionProrationDate()
    {
        return $this->subscriptionProrationDate;
    }

    /**
     * @return int
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * @return int
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @return float
     */
    public function getTaxPercent()
    {
        return $this->taxPercent;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return \DateTime
     */
    public function getWebhooksDeliveredAt()
    {
        return $this->webhooksDeliveredAt;
    }

    /**
     * @param string $object
     *
     * @return StripeLocalInvoice
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * @param int $amountDue
     *
     * @return StripeLocalInvoice
     */
    public function setAmountDue($amountDue)
    {
        $this->amountDue = $amountDue;

        return $this;
    }

    /**
     * @param int $applicationFee
     *
     * @return StripeLocalInvoice
     */
    public function setApplicationFee($applicationFee)
    {
        $this->applicationFee = $applicationFee;

        return $this;
    }

    /**
     * @param int $attemptCount
     *
     * @return StripeLocalInvoice
     */
    public function setAttemptCount($attemptCount)
    {
        $this->attemptCount = $attemptCount;

        return $this;
    }

    /**
     * @param string $charge
     *
     * @return StripeLocalInvoice
     */
    public function setCharge($charge)
    {
        $this->charge = $charge;

        return $this;
    }

    /**
     * @param StripeLocalCustomer $customer
     *
     * @return StripeLocalInvoice
     */
    public function setCustomer(StripeLocalCustomer $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @param \DateTime $date
     *
     * @return StripeLocalInvoice
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return StripeLocalInvoice
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this->description;
    }

    /**
     * @param int $endingBalance
     *
     * @return StripeLocalInvoice
     */
    public function setEndingBalance($endingBalance)
    {
        $this->endingBalance = $endingBalance;

        return $this;
    }

    /**
     * @param string|array $metadata
     *
     * @return StripeLocalInvoice
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @param \DateTime $nextPaymentAttempt
     *
     * @return StripeLocalInvoice
     */
    public function setNextPaymentAttempt($nextPaymentAttempt)
    {
        $this->nextpaymentattempt = $nextPaymentAttempt;

        return $this;
    }

    /**
     * @param \DateTime $periodEnd
     *
     * @return StripeLocalInvoice
     */
    public function setPeriodEnd($periodEnd)
    {
        $this->periodEnd = $periodEnd;

        return $this;
    }

    /**
     * @param \DateTime $periodStart
     *
     * @return StripeLocalInvoice
     */
    public function setPeriodStart($periodStart)
    {
        $this->periodStart = $periodStart;

        return $this;
    }

    /**
     * @param string $recepiptNumber
     *
     * @return StripeLocalInvoice
     */
    public function setReceiptNumber($receiptNumber)
    {
        $this->receiptNumber = $receiptNumber;

        return $this->receiptNumber;
    }

    /**
     * @param int $startingBalance
     *
     * @return StripeLocalInvoice
     */
    public function setStartingBalance($startingBalance)
    {
        $this->startingBalance = $startingBalance;

        return $this;
    }

    /**
     * @param string $statementDescriptor
     *
     * @return StripeLocalInvoice
     */
    public function setStatementDescriptor($statementDescriptor)
    {
        $this->statementDescriptor = $statementDescriptor;

        return $this;
    }

    /**
     * @param string $subscription
     *
     * @return StripeLocalInvoice
     */
    public function setSubscription($subscription)
    {
        return $this;
    }

    /**
     * @param \DateTime $subscriptionProrationDate
     *
     * @return StripeLocalInvoice
     */
    public function setSubscriptionProrationDate($subscriptionProrationDate)
    {
        $this->subscriptionProrationDate = $subscriptionProrationDate;

        return $this;
    }

    /**
     * @param int $subtotal
     *
     * @return StripeLocalInvoice
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    /**
     * @param int $tax
     *
     * @return StripeLocalInvoice
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * @param float $taxPercent
     *
     * @return StripeLocalInvoice
     */
    public function setTaxPercent($taxPercent)
    {
        $this->taxPercent = $taxPercent;

        return $this->taxPercent;
    }

    /**
     * @param int $total
     *
     * @return StripeLocalInvoice
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @param \DateTime $webhooksDeliveredAt
     *
     * @return StripeLocalInvoice
     */
    public function setWebhooksDeliveredAt($webhooksDeliveredAt)
    {
        $this->webhooksDeliveredAt = $webhooksDeliveredAt;

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
             * This checks a customer.
             */
            if (null === $this->getCustomer()) {
                throw new \InvalidArgumentException('To create a Invoice you need to set an Customer.');
            }

            $return = [];

            /*
             * customer required
             *
             * The identifier of the customer to subscribe.
             *
             * @see https://stripe.com/docs/api#create_invoice-customer
             */
            if (null !== $this->getCustomer()->getId()) {
                $return['customer'] = $this->getCustomer()->getId();
            }

            /*
             * application_fee optional
             *
             * A fee in cents that will be applied to the invoice and transferred to the application owner’s Stripe
             * account. The request must be made with an OAuth key or the Stripe-Account header in order to take an
             * application fee. For more information, see the application fees documentation.
             *
             * @see https://stripe.com/docs/api/curl#create_invoice-application_fee
             */
            if (null !== $this->getApplicationFee()) {
                $return['application_fee'] = $this->getApplicationFee();
            }

            /*
             * description optional
             *
             * @see https://stripe.com/docs/api/curl#create_invoice-application_fee
             */
            if (null !== $this->getDescription()) {
                $return['description'] = $this->getDescription();
            }

            /*
             * metadata optional
             *
             * @see https://stripe.com/docs/api/curl#create_invoice-metadata
             */
            if (null !== $this->getMetadata()) {
                $return['metadata'] = $this->getMetadata();
            }

            /*
             * statement_descriptor optional
             *
             * Extra information about a charge for the customer’s credit card statement.
             *
             * @see https://stripe.com/docs/api/curl#create_invoice-statement_descriptor
             */
            if (null !== $this->getStatementDescriptor()) {
                $return['statement_descriptor'] = $this->getStatementDescriptor();
            }

            /*
             * subscription optional
             *
             * The ID of the subscription to invoice. If not set, the created invoice will include all pending invoice
             * items for the customer. If set, the created invoice will exclude pending invoice items that pertain to
             * other subscriptions.
             *
             * @see https://stripe.com/docs/api/curl#create_invoice-subscription
             */
            if (null !== $this->getSubscription()) {
                $return['subscription'] = $this->getSubscription();
            }

            /*
             * tax_percent optional
             *
             * The percent tax rate applied to the invoice, represented as a decimal number.
             *
             * @see https://stripe.com/docs/api/curl#create_invoice-tax_percent
             */
            if (null !== $this->getTaxPercent()) {
                $return['tax_percent'] = $this->getTaxPercent();
            }

        } elseif ('pay' === $action) { // Prepare the array for paying
            $return = [];

            /*
             * at_period_end optional, default is false
             *
             * A flag that if set to true will delay the cancellation of the subscription until the end of the current
             * period.
             *
             * @see https://stripe.com/docs/api#cancel_subscription-at_period_end
             */
            if (null !== $this->getId()) {
                $return['invoice'] = $this->getId();
            }
        }

        return $return;
    }
}
