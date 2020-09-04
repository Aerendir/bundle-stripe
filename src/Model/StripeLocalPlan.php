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

use SerendipityHQ\Component\ValueObjects\Money\Money;

/**
 * @see https://stripe.com/docs/api#plan_object
 */
final class StripeLocalPlan implements StripeLocalResourceInterface
{
    /** @var string */
    private const CREATE = 'create';
    /** @var string|null The Stripe ID of the plan */
    private $id;

    /** @var string */
    private $object;

    /**
     * @var Money
     *
     * The amount in cents to be charged on the interval specified
     *
     * @see https://stripe.com/docs/api#plan_object-amount
     */
    private $amount;

    /** @var \DateTime */
    private $created;

    /**
     * @var string|null
     *
     * Currency in which subscription will be charged
     *
     * @see https://stripe.com/docs/api#plan_object-currency
     */
    private $currency;

    /**
     * @var string|null
     *
     * One of day, week, month or year. The frequency with which a subscription should be billed.
     *
     * @see https://stripe.com/docs/api#plan_object-interval
     */
    private $interval;

    /**
     * @var int
     *
     * The number of intervals (specified in the interval property) between each subscription billing. For example,
     * interval=month and interval_count=3 bills every 3 months.
     *
     * @see https://stripe.com/docs/api#plan_object-interval_count
     */
    private $intervalCount;

    /** @var bool */
    private $livemode;

    /**
     * @var string
     *
     * A set of key/value pairs that you can attach to a plan object. It can be useful for storing additional
     * information about the plan in a structured format.
     *
     * @see https://stripe.com/docs/api#plan_object-metadata
     */
    private $metadata;

    /**
     * @var string|null
     *
     * Display name of the plan
     *
     * @see https://stripe.com/docs/api#plan_object-name
     */
    private $name;

    /**
     * @var string|null
     *
     * Extra information about a charge for the customer’s credit card statement
     *
     * @see https://stripe.com/docs/api#plan_object-statement_descriptor
     */
    private $statementDescriptor;

    /**
     * @var int|null
     *
     * Number of trial period days granted when subscribing a customer to this plan. Null if the plan has no trial
     * period.
     *
     * @see https://stripe.com/docs/api#plan_object-trial_period_days
     */
    private $trialPeriodDays;

    /**
     * Initializes collections.
     */
    public function __construct()
    {
        $this->object = 'plan';
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(string $id): string
    {
        return $this->id = $id;
    }

    /**
     * @return plan|string
     */
    public function getObject(): string
    {
        return $this->object;
    }

    public function getAmount(): \SerendipityHQ\Component\ValueObjects\Money\Money
    {
        return $this->amount;
    }

    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function getInterval(): ?string
    {
        return $this->interval;
    }

    public function getIntervalCount(): int
    {
        return $this->intervalCount;
    }

    public function isLivemode(): bool
    {
        return $this->livemode;
    }

    public function getMetadata(): string
    {
        return $this->metadata;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getStatementDescriptor(): ?string
    {
        return $this->statementDescriptor;
    }

    public function getTrialPeriodDays(): ?int
    {
        return $this->trialPeriodDays;
    }

    public function setObject(string $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function setAmount(\SerendipityHQ\Component\ValueObjects\Money\Money $amount): self
    {
        if (null === $this->amount) {
            $this->amount = $amount;
        }

        return $this;
    }

    public function setCreated(\DateTime $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function setInterval(string $interval): self
    {
        $this->interval = $interval;

        return $this;
    }

    public function setIntervalCount(int $intervalCount): self
    {
        $this->intervalCount = $intervalCount;

        return $this;
    }

    public function setLivemode(bool $livemode): self
    {
        $this->livemode = $livemode;

        return $this;
    }

    public function setMetadata(string $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setStatementDescriptor(?string $statementDescriptor): self
    {
        $this->statementDescriptor = $statementDescriptor;

        return $this;
    }

    public function setTrialPeriodDays(?int $trialPeriodDays): self
    {
        $this->trialPeriodDays = $trialPeriodDays;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toStripe(string $action): array
    {
        if (self::CREATE !== $action && 'update' !== $action) {
            throw new \InvalidArgumentException('StripeLocalPlan::__toArray() accepts only "create" or "update" as parameter.');
        }

        $return = [];

        if (null === $this->getAmount()) {
            throw new \InvalidArgumentException('To create a Plan you need to set an Amount.');
        }
        if (null !== $this->getAmount() && self::CREATE === $action) {
            $return = [
                'amount'   => $this->getAmount()->getBaseAmount(),
                'currency' => $this->getAmount()->getCurrency()->getCode(),
            ];
        }

        if (null !== $this->getId() && self::CREATE === $action) {
            $return['id'] = $this->getId();
        }

        if (null !== $this->getObject() && self::CREATE === $action) {
            $return['object'] = $this->getObject();
        }

        if (null !== $this->getCreated() && self::CREATE === $action) {
            $return['created'] = $this->getCreated();
        }

        if (null !== $this->getInterval() && self::CREATE === $action) {
            $return['interval'] = $this->getInterval();
        }

        if (null !== $this->getIntervalCount() && self::CREATE === $action) {
            $return['interval_count'] = $this->getIntervalCount();
        }

        if (null !== $this->isLivemode() && self::CREATE === $action) {
            $return['livemode'] = $this->isLivemode();
        }

        if (null !== $this->getMetadata() && self::CREATE === $action) {
            $return['metadata'] = $this->getMetadata();
        }

        if (null !== $this->getName() && self::CREATE === $action) {
            $return['name'] = $this->getName();
        }

        if (null !== $this->getStatementDescriptor() && self::CREATE === $action) {
            $return['statement_descriptor'] = $this->getStatementDescriptor();
        }

        if (null !== $this->getTrialPeriodDays() && self::CREATE === $action) {
            $return['trial_period_days'] = $this->getTrialPeriodDays();
        }

        return $return;
    }

    public function __toString(): string
    {
        return $this->getId();
    }
}
