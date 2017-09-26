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

use SerendipityHQ\Component\ValueObjects\Money\Money;

/**
 * @see https://stripe.com/docs/api#plan_object
 */
class StripeLocalPlan implements StripeLocalResourceInterface
{
    /** @var string The Stripe ID of the plan */
    private $id;

    /** @var "plan"|string $object */
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
     * @var int
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

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return string
     */
    public function setId($id)
    {
        return $this->id = $id;
    }

    /**
     * @return 'plan'|string
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return Money
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return string|null
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * @return int
     */
    public function getIntervalCount()
    {
        return $this->intervalCount;
    }

    /**
     * @return bool
     */
    public function isLivemode()
    {
        return $this->livemode;
    }

    /**
     * @return string
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
    public function getStatementDescriptor()
    {
        return $this->statementDescriptor;
    }

    /**
     * @return int
     */
    public function getTrialPeriodDays()
    {
        return $this->trialPeriodDays;
    }

    /**
     * @param string $object
     *
     * @return $this
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * @param Money $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        if (null === $this->amount) {
            $this->amount = $amount;
        }

        return $this;
    }

    /**
     * @param \DateTime $created
     *
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @param string $currency
     *
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @param string $interval
     *
     * @return $this
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;

        return $this;
    }

    /**
     * @param int $intervalCount
     *
     * @return $this
     */
    public function setIntervalCount($intervalCount)
    {
        $this->intervalCount = $intervalCount;

        return $this;
    }

    /**
     * @param bool $livemode
     *
     * @return $this
     */
    public function setLivemode($livemode)
    {
        $this->livemode = $livemode;

        return $this;
    }

    /**
     * @param string $metadata
     *
     * @return $this
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $statementDescriptor
     *
     * @return $this
     */
    public function setStatementDescriptor($statementDescriptor)
    {
        $this->statementDescriptor = $statementDescriptor;

        return $this;
    }

    /**
     * @param int $trialPeriodDays
     *
     * @return $this
     */
    public function setTrialPeriodDays($trialPeriodDays)
    {
        $this->trialPeriodDays = $trialPeriodDays;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toStripe($action)
    {
        if ('create' !== $action && 'update' !== $action) {
            throw new \InvalidArgumentException('StripeLocalPlan::__toArray() accepts only "create" or "update" as parameter.');
        }

        $return = [];

        if (null === $this->getAmount()) {
            throw new \InvalidArgumentException('To create a Plan you need to set an Amount.');
        }
        if (null !== $this->getAmount() && 'create' === $action) {
            $return = [
                'amount'   => $this->getAmount()->getBaseAmount(),
                'currency' => $this->getAmount()->getCurrency()->getCode(),
            ];
        }

        if (null !== $this->getId() && 'create' === $action) {
            $return['id'] = $this->getId();
        }

        if (null !== $this->getObject() && 'create' === $action) {
            $return['object'] = $this->getObject();
        }

        if (null !== $this->getCreated() && 'create' === $action) {
            $return['created'] = $this->getCreated();
        }

        if (null !== $this->getInterval() && 'create' === $action) {
            $return['interval'] = $this->getInterval();
        }

        if (null !== $this->getIntervalCount() && 'create' === $action) {
            $return['interval_count'] = $this->getIntervalCount();
        }

        if (null !== $this->isLivemode() && 'create' === $action) {
            $return['livemode'] = $this->isLivemode();
        }

        if (null !== $this->getMetadata() && 'create' === $action) {
            $return['metadata'] = $this->getMetadata();
        }

        if (null !== $this->getName() && 'create' === $action) {
            $return['name'] = $this->getName();
        }

        if (null !== $this->getStatementDescriptor() && 'create' === $action) {
            $return['statement_descriptor'] = $this->getStatementDescriptor();
        }

        if (null !== $this->getTrialPeriodDays() && 'create' === $action) {
            $return['trial_period_days'] = $this->getTrialPeriodDays();
        }

        return $return;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getId();
    }
}
