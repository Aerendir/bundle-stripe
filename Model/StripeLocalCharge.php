<?php

/*
 * This file is part of the SerendipityHQ Stripe Bundle.
 *
 * Copyright (c) Adamo Crespi <hello@aerendir.me>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Model;

use SerendipityHQ\Component\ValueObjects\Money\Money;
use Stripe\ApiResource;
use Stripe\Charge;

/**
 * @author Adamo Crespi <hello@aerendir.me>
 *
 * @see https://stripe.com/docs/api#charge_object
 */
class StripeLocalCharge implements StripeObjectInterface
{
    /** @var string The Stripe ID of the StripeLocalCharge */
    private $id;

    /** @var Money $amount A positive integer in the smallest currency unit (e.g., 100 cents to charge $1.00 or 100 to charge ¥100, a 0-decimal currency) representing how much to charge. The minimum amount is $0.50 US or equivalent in charge currency. */
    private $amount;

    /** @var string $balanceTransaction ID of the balance transaction that describes the impact of this charge on your account balance (not including refunds or disputes). */
    private $balanceTransaction;

    /** @var bool $captured If the charge was created without capturing, this boolean represents whether or not it is still uncaptured or has since been captured. */
    private $captured;

    /** @var \DateTime */
    private $created;

    /** @var string $currency Three-letter ISO currency code representing the currency in which the charge was made. */
    private $currency;

    /** @var StripeLocalCustomer $customer ID of the customer this charge is for if one exists. */
    private $customer;

    /** @var string */
    private $description;

    /** @var null|string $failureCode Error code explaining reason for charge failure if available (see the errors section for a list of codes). */
    private $failureCode;

    /** @var null|string $failureMessage Message to user further explaining reason for charge failure if available. */
    private $failureMessage;

    /** @var string $fraudDetails Hash with information on fraud assessments for the charge. Assessments reported by you have the key user_report and, if set, possible values of safe and fraudulent. Assessments from Stripe have the key stripe_report and, if set, the value fraudulent. */
    private $fraudDetails;

    /** @var bool */
    private $livemode;

    /** @var string $metadata A set of key/value pairs that you can attach to a charge object. It can be useful for storing additional information about the charge in a structured format. */
    private $metadata;

    /** @var string $order ID of the order this charge is for if one exists. */
    private $order;

    /** @var bool $paid true if the charge succeeded, or was successfully authorized for later capture. */
    private $paid;

    /** @var null|string $receiptEmail This is the email address that the receipt for this charge was sent to. */
    private $receiptEmail;

    /** @var string $receiptNumber This is the transaction number that appears on email receipts sent for this charge. */
    private $receiptNumber;

    /** @var StripeLocalCard $source For most Stripe users, the source of every charge is a credit or debit card. This hash is then the card object describing that card. */
    private $source;

    /** @var string $statementDescriptor Extra information about a charge. This will appear on your customer’s credit card statement. */
    private $statementDescriptor;

    /** @var string $status The status of the payment is either succeeded, pending, or failed. */
    private $status;

    /**
     * StripeLocalCharge constructor.
     *
     * @param null|Charge|array $data
     */
    public function __construct($data = null)
    {
        // If $data are passed...
        if (null !== $data) {
            // If is array
            if (is_array($data)) {
                $this->fromArray($data);
            }

            if ($data instanceof Charge) {
                $this->fromStripeObject($data);
            }

            throw new \InvalidArgumentException('The value passed is not recognized: it can be array, Customer or null.');
        }
    }

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
     * @return string
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return null|string
     */
    public function getFailureCode()
    {
        return $this->failureCode;
    }

    /**
     * @return null|string
     */
    public function getFailureMessage()
    {
        return $this->failureMessage;
    }

    /**
     * @return mixed
     */
    public function getFraudDetails()
    {
        return $this->fraudDetails;
    }

    /**
     * @return mixed
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return bool|string
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * @return null|string
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
     * @return mixed
     */
    public function getStatementDescriptor()
    {
        return $this->statementDescriptor;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return bool
     */
    public function isCaptured()
    {
        return $this->captured;
    }

    /**
     * @return bool
     */
    public function isLivemode()
    {
        return $this->livemode;
    }

    /**
     * @param Money $amount
     *
     * @throws \InvalidArgumentException If the amount is not an integer
     *
     * @return $this
     */
    public function setAmount(Money $amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @param StripeLocalCustomer $customer
     *
     * @return $this
     */
    public function setCustomer(StripeLocalCustomer $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @param StripeLocalCard $card
     *
     * @return $this
     */
    public function setSource(StripeLocalCard $card)
    {
        $this->source = $card;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function fromArray(array $data)
    {
        dump($data);
        throw new \RuntimeException('To implement');
    }

    /**
     * {@inheritdoc}
     */
    public function fromStripeObject(ApiResource $object)
    {
        if (!$object instanceof Charge) {
            throw new \InvalidArgumentException('fromStripeObject accepts only Stripe\Charge objects.');
        }

        dump($object);
        throw new \RuntimeException('To implement');

        /*
        $this->stripeId = $charge->id;
        $this->amount = new PriceEmbeddable(
            new Money([
                'amount' => $charge->amount,
                'currency' => $charge->currency
            ])
        );
        $this->balanceTransaction = $charge->balance_transaction;
        $this->source = $charge->source->id;
        $chargedOn = new \DateTime();
        $this->chargedOn = $chargedOn->setTimestamp($charge->created);
        $this->customerStripeId = $charge->customer;
        $this->paid = $charge->paid;
        $this->status = $charge->status;
        */
    }

    /**
     * {@inheritdoc}
     */
    public function toCreate()
    {
        $return = [];

        return $return;
    }
}
