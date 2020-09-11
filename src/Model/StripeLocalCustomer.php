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
use SerendipityHQ\Component\ValueObjects\Address\AddressInterface;
use SerendipityHQ\Component\ValueObjects\Email\Email;
use SerendipityHQ\Component\ValueObjects\Phone\PhoneInterface;

/**
 * @author Adamo Crespi <hello@aerendir.me>
 *
 * @see https://stripe.com/docs/api#customer_object
 */
class StripeLocalCustomer implements StripeLocalResourceInterface
{
    /** @var array<array-key, string> Properties of the Model that may not be present in the SDK model: these must be ignored when populating the local model */
    public const IGNORE = [
        // This is required by Doctrine to create the relation between Card and Charges
        'cards',

        // This is required by Doctrine to create the relation between Card and Charges
        'charges',

        // This is used by the bundle to manage the creation of a new source for the Customer
        'newSource',
    ];

    /** @var array<array-key, string> Properties of the SDK model classes not implemented in the local model: these must be ignored when populating the local Model */
    public const IGNORE_MODEL = [
        // We already know the type of resource.
        // String representing the object’s type. Objects of the same type share the same value.
        // https://stripe.com/docs/api/customers/object#card_object-object
        'object',

        // @implement This is not currently implemented
        // "Describes the current discount active on the customer, if there is one."
        // https://stripe.com/docs/api/customers/object#customer_object-discount
        'discount',

        // This is not relevant as Invoices are not supported.
        // "The prefix for the customer used to generate unique invoice numbers."
        // https://stripe.com/docs/api/customers/object#customer_object-invoice_prefix
        'invoicePrefix',

        // This is not relevant as Invoices are not supported.
        // "The customer’s default invoice settings."
        // https://stripe.com/docs/api/customers/object#customer_object-invoice_settings
        'invoiceSettings',

        // This is not relevant as Invoices are not supported.
        // "The suffix of the customer’s next invoice number, e.g., 0001."
        // https://stripe.com/docs/api/customers/object#customer_object-next_invoice_sequence
        'nextInvoiceSequence',

        // Not relevant.
        // The customer’s preferred locales (languages), ordered by preference.
        // https://stripe.com/docs/api/customers/object#customer_object-preferred_locales
        'preferredLocales',

        // This is not relevant as Invoices are not supported.
        // "Mailing and shipping address for the customer. Appears on invoices emailed to this customer."
        // https://stripe.com/docs/api/customers/object#customer_object-shipping
        'shipping',

        // This is not relevant as Subscriptions are not supported.
        // ""The customer’s current subscriptions, if any. [...]"
        // https://stripe.com/docs/api/customers/object#customer_object-subscriptions
        'subscriptions',

        // Not relevant as Invoices are not supported.
        // "Describes the customer’s tax exemption status. One of none, exempt, or reverse. When set to reverse, invoice and receipt PDFs include the text “Reverse charge”."
        // https://stripe.com/docs/api/customers/object#customer_object-tax_exempt
        'taxExempt',

        // Not relevant as Invoices are not supported.
        // "The customer’s tax IDs. [...]
        // https://stripe.com/docs/api/customers/object#customer_object-tax_ids
        'taxIds',
    ];

    /** @var string */
    private const ACTION_CREATE = 'create';

    /** @var string The Stripe ID of the StripeLocalCustomer */
    private $id;

    /** @var int|null $balance Current balance, if any, being stored on the customer’s account. If negative, the customer has credit to apply to the next invoice. If positive, the customer has an amount owed that will be added to the next invoice. The balance does not refer to any unpaid invoices; it solely takes into account amounts that have yet to be successfully applied to any invoice. This balance is only taken into account for recurring billing purposes (i.e., subscriptions, invoices, invoice items). */
    private $balance;

    /**
     * @var string
     *
     * "The customer’s full name or business name."
     *
     * @see https://stripe.com/docs/api/customers/object#customer_object-name
     */
    private $name;

    /**
     * @var AddressInterface
     *
     * "The customer’s address."
     *
     * @see https://stripe.com/docs/api/customers/object#customer_object-address
     */
    private $address;

    /**
     * @var PhoneInterface
     *
     * "The customer’s phone number."
     *
     * @see https://stripe.com/docs/api/customers/object#customer_object-phone
     */
    private $phone;

    /** @var ArrayCollection $cards */
    private $cards;

    /** @var ArrayCollection $charges The charges of the customer */
    private $charges;

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

    /** @var Email|null $email */
    private $email;

    /** @var bool $livemode */
    private $livemode;

    /** @var array $metadata A set of key/value pairs that you can attach to a customer object. It can be useful for storing additional information about the customer in a structured format. */
    private $metadata;

    /**
     * @var array
     *
     * "The customer’s payment sources, if any.
     * This field is not included by default. To include it in the response, expand the `sources` field."
     *
     * @see https://stripe.com/docs/api/customers/object#customer_object-sources
     */
    private $sources;

    /** @var string $newSource Used to create a new source for the customer */
    private $newSource;

    /**
     * Initializes the collections.
     */
    public function __construct()
    {
        $this->charges       = new ArrayCollection();
        $this->cards         = new ArrayCollection();
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

    public function getBalance(): ?int
    {
        return $this->balance;
    }

    public function getCards(): ArrayCollection
    {
        return $this->cards;
    }

    public function getCharges(): ArrayCollection
    {
        return $this->charges;
    }

    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getDefaultSource(): ?StripeLocalCard
    {
        return $this->defaultSource;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getEmail(): ?Email
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

    public function removeCharge(StripeLocalCharge $charge): bool
    {
        return $this->charges->removeElement($charge);
    }

    public function setBalance(int $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setEmail(Email $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param $metadata
     */
    public function setMetadata(array $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAddress(): AddressInterface
    {
        return $this->address;
    }

    public function setAddress(AddressInterface $address): void
    {
        $this->address = $address;
    }

    public function getPhone(): PhoneInterface
    {
        return $this->phone;
    }

    public function setPhone(PhoneInterface $phone): void
    {
        $this->phone = $phone;
    }

    public function getSources(): array
    {
        return $this->sources;
    }

    public function setSources(array $sources): void
    {
        $this->sources = $sources;
    }

    public function setNewSource(string $source): self
    {
        if (0 < \strpos($source, 'tok_')) {
            throw new \InvalidArgumentException(\Safe\sprintf('The token you passed seems not to be a card token: %s', $source));
        }

        $this->newSource = $source;

        return $this;
    }

    public function toStripe(string $action): array
    {
        if (self::ACTION_CREATE !== $action && 'update' !== $action) {
            throw new \InvalidArgumentException('StripeLocalCustomer::__toArray() accepts only "create" or "update" as parameter.');
        }

        $return = [];

        if (self::ACTION_CREATE === $action) {
            if (null !== $this->getBalance()) {
                $return['account_balance'] = $this->getBalance();
            }

            if (null !== $this->getDescription()) {
                $return['description'] = $this->getDescription();
            }

            if (null !== $this->getEmail()) {
                $return['email'] = $this->getEmail()->getEmail();
            }

            if (null !== $this->getMetadata()) {
                $return['metadata'] = $this->getMetadata();
            }

            if (null !== $this->getNewSource()) {
                $return['source'] = $this->getNewSource();
            }
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
