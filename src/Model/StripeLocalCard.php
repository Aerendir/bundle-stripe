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

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Adamo Crespi <hello@aerendir.me>
 *
 * @see https://stripe.com/docs/api#card_object
 */
class StripeLocalCard implements StripeLocalResourceInterface
{
    /** @var string The Stripe ID of the card (used in conjunction with a customer or recipient ID) */
    private $id;

    /** @var string|null $addressCity */
    private $addressCity;

    /** @var string|null */
    private $addressCountry;

    /** @var string|null */
    private $addressLine1;

    /** @var string|null $addressLine1Check If address_line1 was provided, results of the check: pass, fail, unavailable, or unchecked. */
    private $addressLine1Check;

    /** @var string|null */
    private $addressLine2;

    /** @var string|null */
    private $addressState;

    /** @var string|null */
    private $addressZip;

    /** @var string|null $addressZipCheck If address_zip was provided, results of the check: pass, fail, unavailable, or unchecked. */
    private $addressZipCheck;

    /** @var string $brand Card brand. Can be Visa, American Express, MasterCard, Discover, JCB, Diners Club, or Unknown. */
    private $brand;

    /** @var string $country Two-letter ISO code representing the country of the card. You could use this attribute to get a sense of the international breakdown of cards you’ve collected. */
    private $country;

    /** @var StripeLocalCustomer $customer The customer that this card belongs to. This attribute will not be in the card object if the card belongs to an account or recipient instead. */
    private $customer;

    /** @var string|null $cvcCheck If a CVC was provided, results of the check: pass, fail, unavailable, or unchecked */
    private $cvcCheck;

    /** @var string|null $dynamicLast4 (For tokenized numbers only.) The last four digits of the device account number. */
    private $dynamicLast4;

    /** @var string */
    private $expMonth;

    /** @var string */
    private $expYear;

    /** @var string|null $error If an error occurred with the card, it is stored here. */
    private $error;

    /** @var string $fingerprint Uniquely identifies this particular card number. You can use this attribute to check whether two customers who’ve signed up with you are using the same card number, for example. */
    private $fingerprint;

    /** @var string Card funding type. Can be credit, debit, prepaid, or unknown */
    private $funding;

    /** @var string */
    private $last4;

    /** @var string|null $metadata A set of key/value pairs that you can attach to a card object. It can be useful for storing additional information about the card in a structured format. */
    private $metadata;

    /** @var string|null $name Cardholder name */
    private $name;

    /** @var string|null $tokenizationMethod If the card number is tokenized, this is the method that was used. Can be apple_pay or android_pay. */
    private $tokenizationMethod;

    /** @var ArrayCollection $charges */
    private $charges;

    /**
     * Initializes collections.
     */
    public function __construct()
    {
        $this->charges = new ArrayCollection();
    }

    /**
     * @param StripeLocalCharge $charge
     *
     * @return $this
     */
    public function addCharge(StripeLocalCharge $charge)
    {
        // If the cards is already set
        if (false === $this->charges->contains($charge)) {
            // Add the card to the collection
            $this->charges->add($charge);
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getAddressCity()
    {
        return $this->addressCity;
    }

    /**
     * @return string|null
     */
    public function getAddressCountry()
    {
        return $this->addressCountry;
    }

    /**
     * @return string|null
     */
    public function getAddressLine1()
    {
        return $this->addressLine1;
    }

    /**
     * @return string|null
     */
    public function getAddressLine1Check()
    {
        return $this->addressLine1Check;
    }

    /**
     * @return string|null
     */
    public function getAddressLine2()
    {
        return $this->addressLine2;
    }

    /**
     * @return string|null
     */
    public function getAddressState()
    {
        return $this->addressState;
    }

    /**
     * @return string|null
     */
    public function getAddressZip()
    {
        return $this->addressZip;
    }

    /**
     * @return string|null
     */
    public function getAddressZipCheck()
    {
        return $this->addressZipCheck;
    }

    /**
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @return ArrayCollection
     */
    public function getCharges()
    {
        return $this->charges;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return StripeLocalCustomer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return string|null
     */
    public function getCvcCheck()
    {
        return $this->cvcCheck;
    }

    /**
     * @return string|null
     */
    public function getDynamicLast4()
    {
        return $this->dynamicLast4;
    }

    /**
     * @return string
     */
    public function getExpMonth()
    {
        return $this->expMonth;
    }

    /**
     * @return string
     */
    public function getExpYear()
    {
        return $this->expYear;
    }

    /**
     * @return string|null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return string
     */
    public function getFingerprint()
    {
        return $this->fingerprint;
    }

    /**
     * @return string
     */
    public function getFunding()
    {
        return $this->funding;
    }

    /**
     * @return string
     */
    public function getLast4()
    {
        return $this->last4;
    }

    /**
     * @return string|null
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getTokenizationMethod()
    {
        return $this->tokenizationMethod;
    }

    /**
     * @param StripeLocalCharge $charge
     *
     * @return bool
     */
    public function removeCharge(StripeLocalCharge $charge)
    {
        return $this->charges->removeElement($charge);
    }

    /**
     * @param $addressCity
     *
     * @return StripeLocalCard
     */
    public function setAddressCity($addressCity): self
    {
        $this->addressCity = $addressCity;

        return $this;
    }

    /**
     * @param $addressCountry
     *
     * @return StripeLocalCard
     */
    public function setAddressCountry($addressCountry): self
    {
        $this->addressCountry = $addressCountry;

        return $this;
    }

    /**
     * @param $addressLine1
     *
     * @return StripeLocalCard
     */
    public function setAddressLine1($addressLine1): self
    {
        $this->addressLine1 = $addressLine1;

        return $this;
    }

    /**
     * @param $addressLine2
     *
     * @return StripeLocalCard
     */
    public function setAddressLine2($addressLine2): self
    {
        $this->addressLine2 = $addressLine2;

        return $this;
    }

    /**
     * @param $addressState
     *
     * @return StripeLocalCard
     */
    public function setAddressState($addressState): self
    {
        $this->addressState = $addressState;

        return $this;
    }

    /**
     * @param $addressZip
     *
     * @return StripeLocalCard
     */
    public function setAddressZip($addressZip): self
    {
        $this->addressZip = $addressZip;

        return $this;
    }

    /**
     * @param $country
     *
     * @return StripeLocalCard
     */
    public function setCountry($country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @param StripeLocalCustomer $customer
     *
     * @return StripeLocalCard
     */
    public function setCustomer(StripeLocalCustomer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @param $expMonth
     *
     * @return StripeLocalCard
     */
    public function setExpMonth($expMonth): self
    {
        $this->expMonth = $expMonth;

        return $this;
    }

    /**
     * @param $expYear
     *
     * @return StripeLocalCard
     */
    public function setExpYear($expYear): self
    {
        $this->expYear = $expYear;

        return $this;
    }

    /**
     * @param string $error
     *
     * @return StripeLocalCard
     */
    public function setError(string $error): self
    {
        $this->error = $error;

        return $this;
    }

    /**
     * @param $metadata
     *
     * @return StripeLocalCard
     */
    public function setMetadata($metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @param $name
     *
     * @return StripeLocalCard
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toStripe($action)
    {
        throw new \RuntimeException('Method not yet implemented.');
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
