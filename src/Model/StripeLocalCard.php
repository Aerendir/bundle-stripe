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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @author Adamo Crespi <hello@aerendir.me>
 *
 * @see https://stripe.com/docs/api#card_object
 */
class StripeLocalCard implements StripeLocalResourceInterface
{
    /** @var array<array-key, string> Properties of the Model that may not be present in the SDK model: these must be ignored when populating the local model */
    public const IGNORE = [
        // This is used internally to save the error returned by the API when calling it
        'error',

        // This is required by Doctrine to create the relation between Card and Charges
        'charges',
    ];

    /** @var array<array-key, string> Properties of the SDK model classes not implemented in the local model: these must be ignored when populating the local Model */
    public const IGNORE_MODEL = [
        // We already know the type of resource.
        // String representing the object’s type. Objects of the same type share the same value.
        // https://stripe.com/docs/api/cards/object#card_object-object
        'object',

        // We don't have an account.
        // "The account this card belongs to. This attribute will not be in the card object if the card belongs to a customer or recipient instead."
        // https://stripe.com/docs/api/cards/object#card_object-account
        'account',

        // Not relevant as Payouts are not implemented.
        // "A set of available payout methods for this card. Only values from this set should be passed as the `method` when creating a payout."
        // https://stripe.com/docs/api/cards/object#card_object-available_payout_methods
        'availablePayoutMethods',

        // Not relevant as Payouts are not implemented.
        // "[CUSTOM CONNECT ONLY] Three-letter ISO code for currency. Only applicable on accounts (not customers or recipients). The card can be used as a transfer destination for funds in this currency."
        // https://stripe.com/docs/api/cards/object#card_object-currency
        'currency',

        // Not relevant as cards are created on the frontend through Stripe.js.
        // More, it is applicable only on accounts and not on customers or recipients.
        // "Applicable only on accounts (not customers or recipients). If you set this to true (or if this is the first external account being added in this currency), this card will become the default external account for its currency."
        // https://stripe.com/docs/api/external_account_cards/create#account_create_card-external_account-default_for_currency
        'defaultForCurrency',

        // Not relevant as it is not applicable to Customers (that are the only models this bundle manages).
        // "The recipient that this card belongs to. This attribute will not be in the card object if the card belongs to a customer or account instead."
        // https://stripe.com/docs/api/cards/object#card_object-recipient
        'recipient',
    ];

    /** @var string The Stripe ID of the card (used in conjunction with a customer or recipient ID) */
    private $id;

    private ?string $addressCity = null;

    private ?string $addressCountry = null;

    private ?string $addressLine1 = null;

    /** If address_line1 was provided, results of the check: pass, fail, unavailable, or unchecked. */
    private ?string $addressLine1Check;

    private ?string $addressLine2 = null;

    private ?string $addressState = null;

    private ?string $addressZip = null;

    /** If address_zip was provided, results of the check: pass, fail, unavailable, or unchecked. */
    private ?string $addressZipCheck;

    /** Card brand. Can be Visa, American Express, MasterCard, Discover, JCB, Diners Club, or Unknown. */
    private ?string $brand;

    /** $country Two-letter ISO code representing the country of the card. You could use this attribute to get a sense of the international breakdown of cards you’ve collected. */
    private ?string $country = null;

    /** The customer that this card belongs to. This attribute will not be in the card object if the card belongs to an account or recipient instead. */
    private ?StripeLocalCustomer $customer = null;

    /** If a CVC was provided, results of the check: pass, fail, unavailable, or unchecked */
    private ?string $cvcCheck;

    /** (For tokenized numbers only.) The last four digits of the device account number. */
    private ?string $dynamicLast4;

    private ?int $expMonth = null;

    private ?int $expYear = null;

    /** Uniquely identifies this particular card number. You can use this attribute to check whether two customers who’ve signed up with you are using the same card number, for example. */
    private ?string $fingerprint;

    /** Card funding type. Can be credit, debit, prepaid, or unknown */
    private string $funding;

    private string $last4;

    /** A set of key/value pairs that you can attach to a card object. It can be useful for storing additional information about the card in a structured format. */
    private array $metadata = [];

    /** Cardholder name */
    private ?string $name = null;

    /** If the card number is tokenized, this is the method that was used. Can be apple_pay or android_pay. */
    private ?string $tokenizationMethod;

    private Collection $charges;

    /** If an error occurred with the card, it is stored here. */
    private ?string $error = null;

    /**
     * Initializes collections.
     */
    public function __construct()
    {
        $this->charges = new ArrayCollection();
    }

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

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function getCharges(): Collection
    {
        return $this->charges;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getCustomer(): ?StripeLocalCustomer
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

    public function getExpMonth(): ?int
    {
        return $this->expMonth;
    }

    public function getExpYear(): ?int
    {
        return $this->expYear;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function getFingerprint(): ?string
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

    public function getMetadata(): array
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

    public function setAddressCity(?string $addressCity): self
    {
        $this->addressCity = $addressCity;

        return $this;
    }

    public function setAddressCountry(?string $addressCountry): self
    {
        $this->addressCountry = $addressCountry;

        return $this;
    }

    public function setAddressLine1(?string $addressLine1): self
    {
        $this->addressLine1 = $addressLine1;

        return $this;
    }

    public function setAddressLine2(?string $addressLine2): self
    {
        $this->addressLine2 = $addressLine2;

        return $this;
    }

    public function setAddressState(?string $addressState): self
    {
        $this->addressState = $addressState;

        return $this;
    }

    public function setAddressZip(?string $addressZip): self
    {
        $this->addressZip = $addressZip;

        return $this;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function setCustomer(StripeLocalCustomer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function setExpMonth(int $expMonth): self
    {
        $this->expMonth = $expMonth;

        return $this;
    }

    public function setExpYear(int $expYear): self
    {
        $this->expYear = $expYear;

        return $this;
    }

    public function setError(string $error): self
    {
        $this->error = $error;

        return $this;
    }

    public function setMetadata(array $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function toStripe(string $action): array
    {
        throw new \RuntimeException('Method not yet implemented.');
    }

    public function __toString(): string
    {
        return $this->getId();
    }
}
