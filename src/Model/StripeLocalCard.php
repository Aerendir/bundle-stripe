<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Adamo Crespi <hello@aerendir.me>
 *
 * @see https://stripe.com/docs/api#card_object
 */
final class StripeLocalCard implements StripeLocalResourceInterface
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
     * @return $this
     */
    public function addCharge(StripeLocalCharge $charge): self
    {
        // If the cards is already set
        if (false === $this->charges->contains($charge)) {
            // Add the card to the collection
            $this->charges->add($charge);
        }

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAddressCity(): ?string
    {
        return $this->addressCity;
    }

    public function getAddressCountry(): ?string
    {
        return $this->addressCountry;
    }

    public function getAddressLine1(): ?string
    {
        return $this->addressLine1;
    }

    public function getAddressLine1Check(): ?string
    {
        return $this->addressLine1Check;
    }

    public function getAddressLine2(): ?string
    {
        return $this->addressLine2;
    }

    public function getAddressState(): ?string
    {
        return $this->addressState;
    }

    public function getAddressZip(): ?string
    {
        return $this->addressZip;
    }

    public function getAddressZipCheck(): ?string
    {
        return $this->addressZipCheck;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getCharges(): \Doctrine\Common\Collections\ArrayCollection
    {
        return $this->charges;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCustomer(): \SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer
    {
        return $this->customer;
    }

    public function getCvcCheck(): ?string
    {
        return $this->cvcCheck;
    }

    public function getDynamicLast4(): ?string
    {
        return $this->dynamicLast4;
    }

    public function getExpMonth(): string
    {
        return $this->expMonth;
    }

    public function getExpYear(): string
    {
        return $this->expYear;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function getFingerprint(): string
    {
        return $this->fingerprint;
    }

    public function getFunding(): string
    {
        return $this->funding;
    }

    public function getLast4(): string
    {
        return $this->last4;
    }

    public function getMetadata(): ?string
    {
        return $this->metadata;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getTokenizationMethod(): ?string
    {
        return $this->tokenizationMethod;
    }

    public function removeCharge(StripeLocalCharge $charge): bool
    {
        return $this->charges->removeElement($charge);
    }

    /**
     * @param $addressCity
     *
     * @return StripeLocalCard
     */
    public function setAddressCity(?string $addressCity): self
    {
        $this->addressCity = $addressCity;

        return $this;
    }

    /**
     * @param $addressCountry
     *
     * @return StripeLocalCard
     */
    public function setAddressCountry(?string $addressCountry): self
    {
        $this->addressCountry = $addressCountry;

        return $this;
    }

    /**
     * @param $addressLine1
     *
     * @return StripeLocalCard
     */
    public function setAddressLine1(?string $addressLine1): self
    {
        $this->addressLine1 = $addressLine1;

        return $this;
    }

    /**
     * @param $addressLine2
     *
     * @return StripeLocalCard
     */
    public function setAddressLine2(?string $addressLine2): self
    {
        $this->addressLine2 = $addressLine2;

        return $this;
    }

    /**
     * @param $addressState
     *
     * @return StripeLocalCard
     */
    public function setAddressState(?string $addressState): self
    {
        $this->addressState = $addressState;

        return $this;
    }

    /**
     * @param $addressZip
     *
     * @return StripeLocalCard
     */
    public function setAddressZip(?string $addressZip): self
    {
        $this->addressZip = $addressZip;

        return $this;
    }

    /**
     * @param $country
     *
     * @return StripeLocalCard
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
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
    public function setExpMonth(string $expMonth): self
    {
        $this->expMonth = $expMonth;

        return $this;
    }

    /**
     * @param $expYear
     *
     * @return StripeLocalCard
     */
    public function setExpYear(string $expYear): self
    {
        $this->expYear = $expYear;

        return $this;
    }

    /**
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
    public function setMetadata(?string $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @param $name
     *
     * @return StripeLocalCard
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toStripe(string $action): array
    {
        throw new \RuntimeException('Method not yet implemented.');
    }

    public function __toString(): string
    {
        return $this->getId();
    }
}
