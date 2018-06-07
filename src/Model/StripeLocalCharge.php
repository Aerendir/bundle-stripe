<?php

/*
 * This file is part of the SHQStripeBundle.
 *
 * Copyright Adamo Aerendir Crespi 2016-2017.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    Adamo Aerendir Crespi <hello@aerendir.me>
 * @copyright Copyright (C) 2016 - 2017 Aerendir. All rights reserved.
 * @license   MIT License.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Model;

use SerendipityHQ\Component\ValueObjects\Email\Email;
use SerendipityHQ\Component\ValueObjects\Money\Money;
use SerendipityHQ\Component\ValueObjects\Money\MoneyInterface;

/**
 * @author Adamo Crespi <hello@aerendir.me>
 *
 * @see https://stripe.com/docs/api#charge_object
 */
class StripeLocalCharge implements StripeLocalResourceInterface
{
    /** @var string The Stripe ID of the StripeLocalCharge */
    private $id;

    /**
     * @var Money
     *
     * A positive integer in the smallest currency unit (e.g., 100 cents to charge $1.00 or 100 to charge ¥100, a
     * 0-decimal currency) representing how much to charge. The minimum amount is $0.50 US or equivalent in charge
     * currency.
     *
     * This is a Money object and the value to use is $amount->getConvertedAmount().
     * This also contains the Currency
     *
     * @see https://stripe.com/docs/api/php#charge_object-amount
     */
    private $amount;

    /**
     * @var string
     *
     * ID of the balance transaction that describes the impact of this charge on your account balance (not including
     * refunds or disputes)
     *
     * @see https://stripe.com/docs/api/php#charge_object-balance_transaction
     */
    private $balanceTransaction;

    /**
     * @var bool
     *
     * If the charge was created without capturing, this boolean represents whether or not it is still uncaptured or has
     * since been captured.
     *
     * https://stripe.com/docs/api/php#charge_object-captured
     */
    private $captured;

    /** @var \DateTime */
    private $created;

    /**
     * @var StripeLocalCustomer
     *
     * ID of the customer this charge is for if one exists
     *
     * @see  https://stripe.com/docs/api/php#charge_object-customer
     */
    private $customer;

    /**
     * @var string optional, default is null.
     *
     * An arbitrary string which you can attach to a charge object. It is displayed when in the web interface
     * alongside the charge. Note that if you use Stripe to send automatic email receipts to your customers,
     * your receipt emails will include the description of the charge(s) that they are describing
     *
     * @see https://stripe.com/docs/api/php#create_charge-description
     */
    private $description;

    /** @var string|null $failureCode Error code explaining reason for charge failure if available (see the errors section for a list of codes). */
    private $failureCode;

    /** @var string|null $failureMessage Message to user further explaining reason for charge failure if available. */
    private $failureMessage;

    /** @var array $fraudDetails Hash with information on fraud assessments for the charge. Assessments reported by you have the key user_report and, if set, possible values of safe and fraudulent. Assessments from Stripe have the key stripe_report and, if set, the value fraudulent. */
    private $fraudDetails;

    /** @var array $outcome Details about whether or not the payment was accepted, and why. See understanding declines for details (https://stripe.com/docs/declines). */
    private $outcome;

    /** @var bool */
    private $livemode;

    /** @var string $metadata A set of key/value pairs that you can attach to a charge object. It can be useful for storing additional information about the charge in a structured format. */
    private $metadata;

    /** @var bool $paid true if the charge succeeded, or was successfully authorized for later capture. */
    private $paid;

    /** @var Email|null $receiptEmail This is the email address that the receipt for this charge was sent to. */
    private $receiptEmail;

    /** @var string $receiptNumber This is the transaction number that appears on email receipts sent for this charge. */
    private $receiptNumber;

    /**
     * @var StripeLocalCard For most Stripe users, the source of every charge is a credit or debit card.
     *                      This hash is then the card object describing that card. There are some checks to
     *                      create a charge
     *
     * @see toStripeArray()
     */
    private $source;

    /** @var string $statementDescriptor Extra information about a charge. This will appear on your customer’s credit card statement. */
    private $statementDescriptor;

    /** @var string $status The status of the payment is either succeeded, pending, or failed. */
    private $status;

    /** @var bool $toCapture Defines if the charge has to be immediately captured or not. Use capture() or notCapture() to set this on or off. */
    private $capture = true;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Money
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getBalanceTransaction()
    {
        return $this->balanceTransaction;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return StripeLocalCustomer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getFailureCode()
    {
        return $this->failureCode;
    }

    /**
     * @return string|null
     */
    public function getFailureMessage()
    {
        return $this->failureMessage;
    }

    /**
     * @return array
     */
    public function getFraudDetails()
    {
        return $this->fraudDetails;
    }

    /**
     * @return array
     */
    public function getOutcome()
    {
        return $this->outcome;
    }

    /**
     * @return string
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return bool|string
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * @return Email|null
     */
    public function getReceiptEmail()
    {
        return $this->receiptEmail;
    }

    /**
     * @return mixed
     */
    public function getReceiptNumber()
    {
        return $this->receiptNumber;
    }

    /**
     * @return StripeLocalCard
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getStatementDescriptor()
    {
        return $this->statementDescriptor;
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * @return bool
     */
    public function isCaptured(): bool
    {
        return $this->captured;
    }

    /**
     * @return bool
     */
    public function isLivemode(): bool
    {
        return $this->livemode;
    }

    /**
     * This sets the amount only if it is null.
     *
     * This is to prevent an accidental overwriting of it.
     *
     * @param Money|MoneyInterface $amount
     *
     * @throws \InvalidArgumentException If the amount is not an integer
     *
     * @return StripeLocalCharge
     */
    public function setAmount(MoneyInterface $amount): self
    {
        if (null === $this->amount) {
            $this->amount = $amount;
        }

        return $this;
    }

    /**
     * @param StripeLocalCustomer $customer
     *
     * @return StripeLocalCharge
     */
    public function setCustomer(StripeLocalCustomer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return StripeLocalCharge
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param array|string $metadata
     *
     * @return StripeLocalCharge
     */
    public function setMetadata($metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @param Email $email
     *
     * @return StripeLocalCharge
     */
    public function setReceiptEmail(Email $email): self
    {
        $this->receiptEmail = $email;

        return $this;
    }

    /**
     * @param string|StripeLocalCard $card
     *
     * @return StripeLocalCharge
     */
    public function setSource($card): self
    {
        if ($card instanceof StripeLocalCard) {
            $card = $card->getId();
        }

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
     * @param $statementDescriptor
     *
     * @return StripeLocalCharge
     *
     * @see https://stripe.com/docs/api/php#create_charge-statement_descriptor
     */
    public function setStatementDescriptor($statementDescriptor): self
    {
        $this->statementDescriptor = $statementDescriptor;

        return $this;
    }

    /**
     * @return StripeLocalCharge
     */
    public function capture(): self
    {
        $this->capture = true;

        return $this;
    }

    /**
     * @return StripeLocalCharge
     */
    public function notCapture(): self
    {
        $this->capture = false;

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
                 * @see https://stripe.com/docs/api/php#create_charge-capture
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
             * @see https://stripe.com/docs/api/php#create_charge-metadata
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
             * @see https://stripe.com/docs/api/php#create_charge-receipt_email
             */
            if (null !== $this->getReceiptEmail()) {
                $return['receipt_email'] = $this->getReceiptEmail()->getEmail();
            }

            /*
             * customer optional, either customer or source is required.
             *
             * The ID of an existing customer that will be charged in this request.
             *
             * @see https://stripe.com/docs/api/php#create_charge-customer
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
             * @see https://stripe.com/docs/api/php#create_charge-source
             */
            if (null !== $this->getSource()) {
                $return['source'] = $this->getSource();
            }

            if (null !== $this->getStatementDescriptor()) {
                $return['statement_descriptor'] = $this->getStatementDescriptor();
            }
        }

        return $return;
    }
}
