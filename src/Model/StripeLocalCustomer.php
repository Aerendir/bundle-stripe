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
use SerendipityHQ\Component\ValueObjects\Email\Email;

/**
 * @author Adamo Crespi <hello@aerendir.me>
 *
 * @see https://stripe.com/docs/api#customer_object
 */
final class StripeLocalCustomer implements StripeLocalResourceInterface
{
    /**
     * @var string
     */
    private const CREATE = 'create';
    /** @var string The Stripe ID of the StripeLocalCustomer */
    private $id;

    /** @var int $accountBalance Current balance, if any, being stored on the customer’s account. If negative, the customer has credit to apply to the next invoice. If positive, the customer has an amount owed that will be added to the next invoice. The balance does not refer to any unpaid invoices; it solely takes into account amounts that have yet to be successfully applied to any invoice. This balance is only taken into account for recurring billing purposes (i.e., subscriptions, invoices, invoice items). */
    private $accountBalance;

    /** @var string $businessVatId The customer’s VAT identification number. */
    private $businessVatId;

    /** @var ArrayCollection $cards */
    private $cards;

    /** @var ArrayCollection $charges The charges of the customer */
    private $charges;

    /** @var ArrayCollection $subscriptions The subscriptions of the customer */
    private $subscriptions;

    /** @var \DateTime $created */
    private $created;

    /** @var string $currency The currency the customer can be charged in for recurring billing purposes. */
    private $currency;

    /** @var StripeLocalCard|null $defaultSource ID of the default source attached to this customer. */
    private $defaultSource;

    /** @var bool $delinquent Whether or not the latest charge for the customer’s latest invoice has failed. */
    private $delinquent;

    /** @var string $description */
    private $description;

    /** @var Email $email */
    private $email;

    /** @var bool $livemode */
    private $livemode;

    /** @var array $metadata A set of key/value pairs that you can attach to a customer object. It can be useful for storing additional information about the customer in a structured format. */
    private $metadata;

    /** @var string $newSource Used to create a new source for the customer */
    private $newSource;

    /**
     * Initializes the collections.
     */
    public function __construct()
    {
        $this->charges       = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
        $this->cards         = new ArrayCollection();
    }

    /**
     * @param StripeLocalCharge $charge
     *
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

    /**
     * @param StripeLocalSubscription $subscription
     *
     * @return $this
     */
    public function addSubscription(StripeLocalSubscription $subscription): self
    {
        // If the subscription is already set
        if (false === $this->subscriptions->contains($subscription)) {
            // Add the subscription to the collection
            $this->subscriptions->add($subscription);
        }

        return $this;
    }

    public function getAccountBalance(): int
    {
        return $this->accountBalance;
    }

    public function getBusinessVatId(): string
    {
        return $this->businessVatId;
    }

    public function getCards(): \Doctrine\Common\Collections\ArrayCollection
    {
        return $this->cards;
    }

    public function getCharges(): \Doctrine\Common\Collections\ArrayCollection
    {
        return $this->charges;
    }

    public function getSubscriptions(): \Doctrine\Common\Collections\ArrayCollection
    {
        return $this->subscriptions;
    }

    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return StripeLocalCard|null
     */
    public function getDefaultSource(): ?StripeLocalCard
    {
        return $this->defaultSource;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getEmail(): \SerendipityHQ\Component\ValueObjects\Email\Email
    {
        return $this->email;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function getNewSource(): string
    {
        return $this->newSource;
    }

    public function isDelinquent(): bool
    {
        return $this->delinquent;
    }

    public function isLivemode(): bool
    {
        return $this->livemode;
    }

    /**
     * @param StripeLocalCharge $charge
     */
    public function removeCharge(StripeLocalCharge $charge): bool
    {
        return $this->charges->removeElement($charge);
    }

    /**
     * @param StripeLocalSubscription $subscription
     */
    public function removeSubscription(StripeLocalSubscription $subscription): bool
    {
        return $this->subscriptions->removeElement($subscription);
    }

    /**
     * @param int $balance
     *
     * @return $this
     */
    public function setAccountBalance(int $balance): self
    {
        $this->accountBalance = $balance;

        return $this;
    }

    /**
     * @param $vat
     *
     * @return $this
     */
    public function setBusinessVatId(string $vat): self
    {
        $this->businessVatId = $vat;

        return $this;
    }

    /**
     * @param string $currency
     *
     * @return $this
     */
    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param Email $email
     *
     * @return $this
     */
    public function setEmail(Email $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param $metadata
     *
     * @return $this
     */
    public function setMetadata(array $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @param string $source
     *
     * @return $this
     */
    public function setNewSource(string $source): self
    {
        if (0 < \strpos($source, 'tok_')) {
            throw new \InvalidArgumentException(\Safe\sprintf('The token you passed seems not to be a card token: %s', $source));
        }

        $this->newSource = $source;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toStripe(string $action): array
    {
        if (self::CREATE !== $action && 'update' !== $action) {
            throw new \InvalidArgumentException('StripeLocalCustomer::__toArray() accepts only "create" or "update" as parameter.');
        }

        $return = [];

        if (null !== $this->getAccountBalance() && self::CREATE === $action) {
            $return['account_balance'] = $this->getAccountBalance();
        }

        if (null !== $this->getBusinessVatId() && self::CREATE === $action) {
            $return['business_vat_id'] = $this->getBusinessVatId();
        }

        if (null !== $this->getDescription() && self::CREATE === $action) {
            $return['description'] = $this->getDescription();
        }

        if (null !== $this->getEmail() && self::CREATE === $action) {
            $return['email'] = $this->getEmail()->getEmail();
        }

        if (null !== $this->getMetadata() && self::CREATE === $action) {
            $return['metadata'] = $this->getMetadata();
        }

        if (null !== $this->getNewSource() && self::CREATE === $action) {
            $return['source'] = $this->getNewSource();
        }

        return $return;
    }

    /**
     * Transforms metadata from string to array.
     *
     * As metadata can be set by the developer or by reflection during syncronization of the StripeCustomer object with
     * this local one, may happen the value is a string.
     *
     * This lifecycle callback ensures the value ever is an array.
     */
    public function metadataTransformer(): void
    {
        if (\is_string($this->getMetadata())) {
            $this->setMetadata(\Safe\json_decode($this->getMetadata(), true));
        }
    }

    public function __toString(): string
    {
        return $this->getId();
    }
}
