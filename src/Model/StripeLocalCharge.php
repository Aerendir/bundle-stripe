<?php

declare(strict_types=1);

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Model;

use SerendipityHQ\Component\ValueObjects\Email\Email;
use SerendipityHQ\Component\ValueObjects\Money\Money;
use SerendipityHQ\Component\ValueObjects\Money\MoneyInterface;
use SerendipityHQ\Component\ValueObjects\Uri\UriInterface;

/**
 * @author Adamo Crespi <hello@aerendir.me>
 *
 * @see https://stripe.com/docs/api#charge_object
 */
class StripeLocalCharge implements StripeLocalResourceInterface
{
    /** @var array<array-key, string> Properties of the Model that may not be present in the SDK model: these must be ignored when populating the local model */
    public const IGNORE = [
        // This is an optional parameter required when creating a charge and not returned by the SDK
        // "Whether to immediately capture the charge. Defaults to true. When false, the charge issues an authorization (or pre-authorization), and will need to be captured later. Uncaptured charges expire in seven days. [...]"
        // https://stripe.com/docs/api/charges/create#create_charge-capture
        'capture',
    ];

    /** @var array<array-key, string> Properties of the SDK model classes not implemented in the local model: these must be ignored when populating the local Model */
    public const IGNORE_MODEL = [
        // We already know the type of resource.
        // String representing the object’s type. Objects of the same type share the same value.
        // https://stripe.com/docs/api/charges/object#card_object-object
        'object',

        // [CONNECT ONLY] Not relevant.
        // "ID of the Connect application that created the charge."
        // https://stripe.com/docs/api/charges/object#charge_object-application
        'application',

        // [CONNECT ONLY] Not relevant.
        // "The application fee (if any) for the charge. [...]"
        // https://stripe.com/docs/api/charges/object#charge_object-application_fee
        'applicationFee',

        // [CONNECT ONLY] Not relevant.
        // "The amount of the application fee (if any) requested for the charge. [...]"
        // https://stripe.com/docs/api/charges/object#charge_object-application_fee_amount
        'applicationFeeAmount',

        // [CONNECT ONLY] Not relevant.
        // "Three-letter ISO code for currency. Only applicable on accounts (not customers or recipients). The card can be used as a transfer destination for funds in this currency."
        // https://stripe.com/docs/api/charges/object#charge_object-currency
        'currency',

        // [CONNECT ONLY] Not relevant.
        // Not found in docs
        // Not found in docs
        'destination',

        // @implement This is not currently implemented
        // [Not found in documentation]
        // [Not found in documentation]
        'dispute',

        // Not relevant as invoices are not supported.
        // "ID of the invoice this charge is for if one exists."
        // https://stripe.com/docs/api/charges/object#charge_object-invoice
        'invoice',

        // [CONNECT ONLY] Not relevant.
        // "The account (if any) the charge was made on behalf of without triggering an automatic transfer. [...]"
        // https://stripe.com/docs/api/charges/object#charge_object-on_behalf_of
        'onBehalfOf',

        // Not relevant as orders are not supported.
        // ID of the order this charge is for if one exists.
        // https://stripe.com/docs/api/charges/object#charge_object-order
        'order',

        // [CONNECT ONLY] Not relevant.
        // "ID of the transfer to the destination account (only applicable if the charge was created using the destination parameter)."
        // https://stripe.com/docs/api/charges/object#charge_object-transfer
        'transfer',

        // [CONNECT ONLY] Not relevant.
        // "An optional dictionary including the account to automatically transfer to as part of a destination charge. [...]"
        // https://stripe.com/docs/api/charges/object#charge_object-transfer_data
        'transferData',

        // [CONNECT ONLY] Not relevant.
        // "The transfer ID which created this charge. Only present if the charge came from another Stripe account. [...]"
        // https://stripe.com/docs/api/charges/object#charge_object-source_transfer
        'sourceTransfer',

        // [CONNECT ONLY] Not relevant.
        // "A string that identifies this transaction as part of a group. [...]"
        // https://stripe.com/docs/api/charges/object#charge_object-transfer_group
        'transferGroup',

        // Not relevant as payment intents are not supported.
        // ID of the PaymentIntent associated with this charge, if one exists.
        // https://stripe.com/docs/api/charges/object?lang=php#charge_object-payment_intent
        'paymentIntent',

        // Not supported
        // Shipping information for the charge.
        // https://stripe.com/docs/api/charges/object#charge_object-shipping
        'shipping',
    ];

    /** @var string The Stripe ID of the StripeLocalCharge */
    private $id;

    /**
     * @var Money
     *
     * "A positive integer in the smallest currency unit (e.g., 100 cents to charge $1.00 or 100 to charge ¥100, a
     * 0-decimal currency) representing how much to charge. The minimum amount is $0.50 US or equivalent in charge
     * currency.
     * The amount value supports up to eight digits (e.g., a value of 99999999 for a USD charge of $999,999.99)."
     *
     * This is represented as a Money object, that also contains the Currency.
     *
     * @see https://stripe.com/docs/api/php#charge_object-amount
     */
    private $amount;

    /**
     * @var Money
     *
     * "Amount in cents refunded (can be less than the amount attribute on the charge if a partial refund was issued)."
     *
     * This is represented as a Money object, that also contains the Currency.
     *
     * @see https://stripe.com/docs/api/charges/object#charge_object-amount_refunded
     */
    private $amountRefunded;

    /**
     * @var string|null
     *
     * ID of the balance transaction that describes the impact of this charge on your account balance (not including
     * refunds or disputes)
     *
     * @see https://stripe.com/docs/api/php#charge_object-balance_transaction
     */
    private $balanceTransaction;

    /**
     * @var array
     *
     * "Billing information associated with the payment method at the time of the transaction."
     *
     * @see https://stripe.com/docs/api/charges/object#charge_object-billing_details
     */
    private $billingDetails;

    /**
     * @var bool
     *
     * If the charge was created without capturing, this boolean represents whether or not it is still uncaptured or has
     * since been captured.
     *
     * https://stripe.com/docs/api/php#charge_object-captured
     */
    private $captured = false;

    /** @var \DateTimeInterface */
    private $created;

    /**
     * @var bool
     *
     * "Whether the charge has been disputed."
     *
     * @see https://stripe.com/docs/api/charges/object#charge_object-disputed
     */
    private $disputed = false;

    /**
     * @var bool
     *
     * "Whether the charge has been fully refunded. If the charge is only partially refunded, this attribute will still be false."
     *
     * @see https://stripe.com/docs/api/charges/object#charge_object-refunded
     */
    private $refunded = false;

    /**
     * @var array
     *
     * "A list of refunds that have been applied to the charge."
     *
     * @see https://stripe.com/docs/api/charges/object#charge_object-refunds
     */
    private $refunds;

    /**
     * @var StripeLocalCustomer|null
     *
     * ID of the customer this charge is for if one exists
     *
     * @see  https://stripe.com/docs/api/php#charge_object-customer
     */
    private $customer;

    /**
     * @var string|null
     *
     * An arbitrary string which you can attach to a charge object. It is displayed when in the web interface
     * alongside the charge. Note that if you use Stripe to send automatic email receipts to your customers,
     * your receipt emails will include the description of the charge(s) that they are describing
     *
     * @see https://stripe.com/docs/api/php#create_charge-description
     */
    private $description;

    /** @var string|null $failureCode error code explaining reason for charge failure if available (see the errors section for a list of codes) */
    private $failureCode;

    /** @var string|null $failureMessage Message to user further explaining reason for charge failure if available. */
    private $failureMessage;

    /** @var array|null $fraudDetails Hash with information on fraud assessments for the charge. Assessments reported by you have the key user_report and, if set, possible values of safe and fraudulent. Assessments from Stripe have the key stripe_report and, if set, the value fraudulent. */
    private $fraudDetails;

    /** @var array|null $outcome Details about whether or not the payment was accepted, and why. See understanding declines for details (https://stripe.com/docs/declines). */
    private $outcome;

    /** @var bool */
    private $livemode = false;

    /** @var array $metadata A set of key/value pairs that you can attach to a charge object. It can be useful for storing additional information about the charge in a structured format. */
    private $metadata = [];

    /** @var bool $paid true if the charge succeeded, or was successfully authorized for later capture. */
    private $paid = false;

    /** @var Email|null $receiptEmail This is the email address that the receipt for this charge was sent to. */
    private $receiptEmail;

    /** @var string|null $receiptNumber This is the transaction number that appears on email receipts sent for this charge. */
    private $receiptNumber;

    /**
     * @var StripeLocalCard|null For most Stripe users, the source of every charge is a credit or debit card.
     *                           This hash is then the card object describing that card. There are some checks to
     *                           create a charge
     *
     * @see toStripeArray()
     */
    private $source;

    /**
     * @var string|null $statementDescriptor
     *
     * "For card charges, use statement_descriptor_suffix instead. Otherwise, you can use this value as the complete description of a charge on your customers’ statements. Must contain at least one letter, maximum 22 characters."
     *
     * @see https://stripe.com/docs/api/charges/object#charge_object-statement_descriptor
     */
    private $statementDescriptor;

    /**
     * @var string|null
     *
     * "The full statement descriptor that is passed to card networks, and that is displayed on your customers’ credit card and bank statements. Allows you to see what the statement descriptor looks like after the static and dynamic portions are combined."
     *
     * @see https://stripe.com/docs/api/charges/object#charge_object-calculated_statement_descriptor
     */
    private $calculatedStatementDescriptor;

    /**
     * @var string|null
     *
     * "Provides information about the charge that customers see on their statements. Concatenated with the prefix (shortened descriptor) or statement descriptor that’s set on the account to form the complete statement descriptor. Maximum 22 characters for the concatenated descriptor."
     *
     * @see https://stripe.com/docs/api/charges/object#charge_object-statement_descriptor_suffix
     */
    private $statementDescriptorSuffix;

    /**
     * @var string
     *
     * The status of the payment is either succeeded, pending, or failed
     */
    private $status;

    /**
     * @var string|null
     *
     * "ID of the payment method used in this charge."
     *
     * @see https://stripe.com/docs/api/charges/object#charge_object-payment_method
     */
    private $paymentMethod;

    /**
     * @var array|null
     *
     * Details about the payment method at the time of the transaction
     *
     * @see https://stripe.com/docs/api/charges/object#charge_object-payment_method_details
     */
    private $paymentMethodDetails;

    /**
     * @var UriInterface|null
     *
     * "This is the URL to view the receipt for this charge. The receipt is kept up-to-date to the latest state of the charge, including any refunds. If the charge is for an Invoice, the receipt will be stylized as an Invoice receipt."
     *
     * @see https://stripe.com/docs/api/charges/object#charge_object-receipt_url
     */
    private $receiptUrl;

    /**
     * @var string|null
     *
     * "ID of the review associated with this charge if one exists."
     *
     * @see https://stripe.com/docs/api/charges/object#charge_object-review
     */
    private $review;

    /**
     * @var bool
     *
     * Defines if the charge has to be immediately captured or not. Use capture() or notCapture() to set this on or off.
     */
    private $capture = true;

    public function __construct()
    {
        // Here we use EUR as it is irrelevant: the amunt is simply 0.
        // Once the objet will be synced with Stripe, then, the correct currency will be set.
        $this->amountRefunded = new Money([MoneyInterface::BASE_AMOUNT => 0, MoneyInterface::CURRENCY => 'EUR']);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getBalanceTransaction(): ?string
    {
        return $this->balanceTransaction;
    }

    public function getCreated(): \DateTimeInterface
    {
        return $this->created;
    }

    public function getCustomer(): ?StripeLocalCustomer
    {
        return $this->customer;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getFailureCode(): ?string
    {
        return $this->failureCode;
    }

    public function getFailureMessage(): ?string
    {
        return $this->failureMessage;
    }

    public function getFraudDetails(): ?array
    {
        return $this->fraudDetails;
    }

    public function getOutcome(): ?array
    {
        return $this->outcome;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * @return bool|string
     */
    public function getPaid(): bool
    {
        return $this->paid;
    }

    public function getReceiptEmail(): ?Email
    {
        return $this->receiptEmail;
    }

    public function getReceiptNumber(): ?string
    {
        return $this->receiptNumber;
    }

    public function getSource(): ?StripeLocalCard
    {
        return $this->source;
    }

    public function getStatementDescriptor(): ?string
    {
        return $this->statementDescriptor;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function isCaptured(): bool
    {
        return $this->captured;
    }

    public function isLivemode(): bool
    {
        return $this->livemode;
    }

    public function setAmount(MoneyInterface $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function setCustomer(?StripeLocalCustomer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setMetadata(array $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    public function setReceiptEmail(Email $email): self
    {
        $this->receiptEmail = $email;

        return $this;
    }

    public function setSource(?StripeLocalCard $card): self
    {
        $this->source = $card;

        return $this;
    }

    /**
     * statement_descriptor optional, default is null.
     *
     * An arbitrary string to be displayed on your customer's credit card statement. This may be up to 22
     * characters. As an example, if your website is RunClub and the item you're charging for is a race ticket,
     * you may want to specify a statement_descriptor of RunClub 5K race ticket.
     *
     * The statement description may not include <>"' characters, and will appear on your customer's statement in
     * capital letters. Non-ASCII characters are automatically stripped. While most banks display this information
     * consistently, some may display it incorrectly or not at all.
     *
     * @see https://stripe.com/docs/api/php#create_charge-statement_descriptor
     */
    public function setStatementDescriptor(?string $statementDescriptor): self
    {
        $this->statementDescriptor = $statementDescriptor;

        return $this;
    }

    public function capture(): self
    {
        $this->capture = true;

        return $this;
    }

    public function notCapture(): self
    {
        $this->capture = false;

        return $this;
    }

    public function getAmountRefunded(): Money
    {
        return $this->amountRefunded;
    }

    public function setAmountRefunded(Money $amountRefunded): void
    {
        $this->amountRefunded = $amountRefunded;
    }

    public function getBillingDetails(): array
    {
        return $this->billingDetails;
    }

    public function setBillingDetails(array $billingDetails): void
    {
        $this->billingDetails = $billingDetails;
    }

    public function isDisputed(): bool
    {
        return $this->disputed;
    }

    public function setDisputed(bool $disputed): void
    {
        $this->disputed = $disputed;
    }

    public function isRefunded(): bool
    {
        return $this->refunded;
    }

    public function setRefunded(bool $refunded): void
    {
        $this->refunded = $refunded;
    }

    public function getRefunds(): array
    {
        return $this->refunds;
    }

    public function setRefunds(array $refunds): void
    {
        $this->refunds = $refunds;
    }

    public function getCalculatedStatementDescriptor(): ?string
    {
        return $this->calculatedStatementDescriptor;
    }

    public function setCalculatedStatementDescriptor(?string $calculatedStatementDescriptor): void
    {
        $this->calculatedStatementDescriptor = $calculatedStatementDescriptor;
    }

    public function getStatementDescriptorSuffix(): ?string
    {
        return $this->statementDescriptorSuffix;
    }

    public function setStatementDescriptorSuffix(?string $statementDescriptorSuffix): void
    {
        $this->statementDescriptorSuffix = $statementDescriptorSuffix;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?string $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function getPaymentMethodDetails(): ?array
    {
        return $this->paymentMethodDetails;
    }

    public function setPaymentMethodDetails(?array $paymentMethodDetails): void
    {
        $this->paymentMethodDetails = $paymentMethodDetails;
    }

    public function getReceiptUrl(): ?UriInterface
    {
        return $this->receiptUrl;
    }

    public function setReceiptUrl(?UriInterface $receiptUrl): void
    {
        $this->receiptUrl = $receiptUrl;
    }

    public function getReview(): ?string
    {
        return $this->review;
    }

    public function setReview(?string $review): void
    {
        $this->review = $review;
    }

    public function isCapture(): bool
    {
        return $this->capture;
    }

    public function setCapture(bool $capture): void
    {
        $this->capture = $capture;
    }

    public function toStripe(string $action): array
    {
        $return = [];

        // Prepare the array for creation
        if ('create' === $action) {
            /*
             * This checks an amount is set.
             *
             * As the amount is a Money object, if it exists, also a Currency exists.
             */
            if (null === $this->amount) {
                throw new \InvalidArgumentException('To create a Charge you need to set an Amount.');
            }

            $return = [
                'amount'   => $this->getAmount()->getBaseAmount(),
                'currency' => $this->getAmount()->getCurrency()->getCode(),

                /*
                 * capture, optional, default is true.
                 *
                 * Whether or not to immediately capture the charge. When false, the charge issues an authorization (or
                 * pre-authorization), and will need to be captured later. Uncaptured charges expire in 7 days. For more
                 * information, see authorizing charges and settling later.
                 *
                 * @link https://stripe.com/docs/api/php#create_charge-capture
                 */
                'capture' => $this->capture,
                ];

            if (null !== $this->getDescription()) {
                $return['description'] = $this->getDescription();
            }

            /*
             * metadata optional, default is { }.
             *
             * A set of key/value pairs that you can attach to a charge object. It can be useful for storing additional
             * information about the customer in a structured format. It's often a good idea to store an email address
             * in metadata for tracking later.
             *
             * @link https://stripe.com/docs/api/php#create_charge-metadata
             */
            if (null !== $this->getMetadata()) {
                $return['metadata'] = $this->getMetadata();
            }

            /*
             * receipt_email optional, default is null.
             *
             * The email address to send this charge's receipt to. The receipt will not be sent until the charge is
             * paid. If this charge is for a customer, the email address specified here will override the customer's
             * email address. Receipts will not be sent for test mode charges. If receipt_email is specified for a
             * charge in live mode, a receipt will be sent regardless of your email settings.
             *
             * @link https://stripe.com/docs/api/php#create_charge-receipt_email
             */
            if (null !== $this->getReceiptEmail()) {
                $return['receipt_email'] = $this->getReceiptEmail()->getEmail();
            }

            /*
             * customer optional, either customer or source is required.
             *
             * The ID of an existing customer that will be charged in this request.
             *
             * @link https://stripe.com/docs/api/php#create_charge-customer
             */
            if (null !== $this->getCustomer()->getId()) {
                $return['customer'] = $this->getCustomer()->getId();
            }

            /*
             * source optional, either source or customer is required.
             *
             * A payment source to be charged, such as a credit card. If you also pass a customer ID, the source must be
             * the ID of a source belonging to the customer. Otherwise, if you do not pass a customer ID, the source you
             * provide must either be a token, like the ones returned by Stripe.js, or a associative array containing a
             * user's credit card details, with the options described below.
             * Although not all information is required, the extra info helps prevent fraud.
             *
             * @link https://stripe.com/docs/api/php#create_charge-source
             */
            if (null !== $this->getSource()) {
                $return['source'] = $this->getSource()->getId();
            }

            if (null !== $this->getStatementDescriptor()) {
                $return['statement_descriptor'] = $this->getStatementDescriptor();
            }
        }

        return $return;
    }
}
