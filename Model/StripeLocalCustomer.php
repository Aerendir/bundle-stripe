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

use Doctrine\Common\Collections\ArrayCollection;
use Stripe\ApiResource;
use Stripe\Customer;

/**
 * @author Adamo Crespi <hello@aerendir.me>
 *
 * @see https://stripe.com/docs/api#customer_object
 */
class StripeLocalCustomer implements StripeObjectInterface
{
    /** @var string The Stripe ID of the StripeLocalCustomer*/
    private $id;

    /** @var  int $accountBalance Current balance, if any, being stored on the customer’s account. If negative, the customer has credit to apply to the next invoice. If positive, the customer has an amount owed that will be added to the next invoice. The balance does not refer to any unpaid invoices; it solely takes into account amounts that have yet to be successfully applied to any invoice. This balance is only taken into account for recurring billing purposes (i.e., subscriptions, invoices, invoice items). */
    private $accountBalance;

    /** @var string $businessVatId The customer’s VAT identification number. */
    private $businessVatId;

    /** @var ArrayCollection $charges The charges of the customer */
    private $charges;

    /** @var  \DateTime $created */
    private $created;

    /** @var  string $currency The currency the customer can be charged in for recurring billing purposes. */
    private $currency;

    /** @var  StripeLocalCard $defaultSource ID of the default source attached to this customer. */
    private $defaultSource;

    /** @var  bool $delinquent Whether or not the latest charge for the customer’s latest invoice has failed. */
    private $delinquent;

    /** @var  string $description */
    private $description;

    /** @var  string $email */
    private $email;

    /** @var  bool $livemode */
    private $livemode;

    /** @var string $metadata A set of key/value pairs that you can attach to a customer object. It can be useful for storing additional information about the customer in a structured format.  */
    private $metadata;

    /** @var  int $quantity */
    private $quantity;

    /** @var  ArrayCollection $sources The credit cards associated with this customer */
    private $sources;

    /**
     * Initializes the collections.
     *
     * @param array|Customer|null $data
     */
    public function __construct($data = null)
    {
        $this->charges = new ArrayCollection();
        $this->sources = new ArrayCollection();

        // If $data are passed...
        if (null !== $data) {
            // If is array
            if (is_array($data)) {
                $this->fromArray($data);
            }

            if ($data instanceof Customer) {
                $this->fromStripeObject($data);
            }

            throw new \InvalidArgumentException('The value passed is not recognized: it can be array, Customer or null.');
        }
    }

    /**
     * @param StripeLocalCard $card
     *
     * @return $this
     */
    public function addSource(StripeLocalCard $card)
    {
        // If the cards is already set
        if ($this->sources->contains($card)) {
            // Return
            return $this;
        }

        // Add the card to the collection
        $this->sources->add($card);

        return $this;
    }

    /**
     * @param StripeLocalCharge $charge
     *
     * @return $this
     */
    public function addCharge(StripeLocalCharge $charge)
    {
        // If the cards is already set
        if ($this->charges->contains($charge)) {
            // Return
            return $this;
        }

        // Add the card to the collection
        $this->charges->add($charge);

        return $this;
    }

    /**
     * @return int
     */
    public function getAccountBalance()
    {
        return $this->accountBalance;
    }

    /**
     * @return string
     */
    public function getBusinessVatId()
    {
        return $this->businessVatId;
    }

    /**
     * @return ArrayCollection
     */
    public function getCharges()
    {
        return $this->charges;
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
     * @return StripeLocalCard
     */
    public function getDefaultSource()
    {
        return $this->defaultSource;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return ArrayCollection
     */
    public function getSources()
    {
        return $this->sources;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return bool
     */
    public function isDelinquent()
    {
        return $this->delinquent;
    }

    /**
     * @return bool
     */
    public function isLivemode()
    {
        return $this->livemode;
    }

    /**
     * @param StripeLocalCard $card
     *
     * @return bool
     */
    public function removeSource(StripeLocalCard $card)
    {
        return $this->sources->removeElement($card);
    }

    /**
     * @param $balance
     *
     * @return $this
     */
    public function setAccountBalance($balance)
    {
        $this->accountBalance = $balance;

        return $this;
    }

    /**
     * @param $vat
     *
     * @return $this
     */
    public function setBusinessVatId($vat)
    {
        $this->businessVatId = $vat;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param $metadata
     *
     * @return $this
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @param $quantity
     *
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function fromArray(array $data)
    {
        if (empty($data)) {
            return $this;
        }

        if (isset($data['account_balance'])) {
            $this->setAccountBalance($data['account_balance']);
        }

        if (isset($data['business_vat_id'])) {
            $this->setBusinessVatId($data['business_vat_id']);
        }

        if (isset($data['description'])) {
            $this->setDescription($data['description']);
        }

        if (isset($data['email'])) {
            $this->setDescription($data['email']);
        }

        if (isset($data['metadata'])) {
            $this->setMetadata($data['metadata']);
        }

        if (isset($data['quantity'])) {
            $this->setQuantity($data['quantity']);
        }

        if (isset($data['source'])) {
            $this->setQuantity($data['source']);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function fromStripeObject(ApiResource $object)
    {
        if (!$object instanceof Customer) {
            throw new \InvalidArgumentException('fromStripeObject accepts only Stripe\Customer objects.');
        }

        throw new \RuntimeException('To implement');
    }

    /**
     * {@inheritdoc}
     */
    public function toCreate()
    {
        $return = [];

        if (null !== $this->getAccountBalance()) {
            $return['account_balance'] = $this->getAccountBalance();
        }

        if (null !== $this->getBusinessVatId()) {
            $return['business_vat_id'] = $this->getBusinessVatId();
        }

        if (null !== $this->getDescription()) {
            $return['description'] = $this->getDescription();
        }

        if (null !== $this->getEmail()) {
            $return['email'] = $this->getEmail();
        }

        if (null !== $this->getMetadata()) {
            $return['metadata'] = $this->getMetadata();
        }

        if (null !== $this->getDefaultSource()) {
            $return['metadata'] = $this->getDefaultSource();
        }

        return $return;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getId();
    }
}
