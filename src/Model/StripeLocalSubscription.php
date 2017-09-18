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

/**
 * @see https://stripe.com/docs/api#subscription_object
 */
class StripeLocalSubscription implements StripeLocalResourceInterface
{
    /** @var string The Stripe ID of the StripeLocalSubscription */
    private $id;

    /**
     * @var float
     *
     * A positive decimal that represents the fee percentage of the subscription invoice amount that will be transferred
     * to the application owner’s Stripe account each billing period
     *
     * @see https://stripe.com/docs/api#subscription_object-application_fee_percent
     */
    private $applicationFeePercent;

    /**
     * @var bool
     *
     * If the subscription has been canceled with the at_period_end flag set to true, cancel_at_period_end on the
     * subscription will be true. You can use this attribute to determine whether a subscription that has a status of
     * active is scheduled to be canceled at the end of the current period.
     *
     * @see https://stripe.com/docs/api#subscription_object-cancel_at_period_end
     */
    private $cancelAtPeriodEnd;

    /**
     * @var \DateTime
     *
     * If the subscription has been canceled, the date of that cancellation. If the subscription was canceled with
     * cancel_at_period_end, canceled_at will still reflect the date of the initial cancellation request, not the end of
     * the subscription period when the subscription is automatically moved to a canceled state.
     *
     * @see https://stripe.com/docs/api#subscription_object-canceled_at
     */
    private $canceledAt;

    /** @var \DateTime */
    private $created;

    /**
     * @var \DateTime
     *
     * End of the current period that the subscription has been invoiced for. At the end of this period, a new invoice
     * will be created.
     *
     * @see https://stripe.com/docs/api#subscription_object-current_period_end
     */
    private $currentPeriodEnd;

    /**
     * @var \DateTime
     *
     * Start of the current period that the subscription has been invoiced for
     *
     * @see https://stripe.com/docs/api#subscription_object-current_period_start
     */
    private $currentPeriodStart;

    /**
     * @var StripeLocalCustomer
     *
     * ID of the customer this charge is for if one exists
     *
     * @see  https://stripe.com/docs/api/php#charge_object-customer
     */
    private $customer;

    /**
     * @var string discountObject optional, default is null
     *
     * @see https://stripe.com/docs/api#discount_object
     *
     * Describes the current discount applied to this subscription, if there is one. When billing, a discount applied to
     * a subscription overrides a discount applied on a customer-wide basis.
     * @see https://stripe.com/docs/api#subscription_object-discount
     */
    private $discount;

    /**
     * @var \DateTime
     *
     * If the subscription has ended (either because it was canceled or because the customer was switched to a
     * subscription to a new plan), the date the subscription ended
     *
     * @see https://stripe.com/docs/api#subscription_object-ended_at
     */
    private $endedAt;

    /** @var bool */
    private $livemode;

    /** @var string
     * A set of key/value pairs that you can attach to a charge object. It can be useful for storing additional
     * information about the charge in a structured format.
     *
     * @see https://stripe.com/docs/api#subscription_object-metadata
     */
    private $metadata;

    /**
     * @var string
     *             Hash describing the plan the customer is subscribed to
     *
     * @see https://stripe.com/docs/api#subscription_object-plan
     */
    private $plan;

    /** @var int
     * The quantity of the plan to which the customer should be subscribed. For example, if your plan is $10/user/month,
     * and your customer has 5 users, you could pass 5 as the quantity to have the customer charged $50 (5 x $10)
     * monthly.
     *
     * @see https://stripe.com/docs/api#subscription_object-quantity
     **/
    private $quantity;

    /**
     * @var \DateTime
     *
     * Date the most recent update to this subscription started
     *
     * @see https://stripe.com/docs/api#subscription_object-start
     */
    private $start;

    /**
     * @var string
     *
     * Possible values are trialing, active, past_due, canceled, or unpaid. A subscription still in its trial period is
     * trialing and moves to active when the trial period is over. When payment to renew the subscription fails, the
     * subscription becomes past_due. After Stripe has exhausted all payment retry attempts, the subscription ends up
     * with a status of either canceled or unpaid depending on your retry settings. Note that when a subscription has a
     * status of unpaid, no subsequent invoices will be attempted (invoices will be created, but then immediately
     * automatically closed. Additionally, updating customer card details will not lead to Stripe retrying the latest
     * invoice.). After receiving updated card details from a customer, you may choose to reopen and pay their closed
     * invoices.
     *
     * @see https://stripe.com/docs/api#subscription_object-status
     */
    private $status;

    /**
     * @var float
     *
     * If provided, each invoice created by this subscription will apply the tax rate, increasing the amount billed to
     * the customer
     *
     * @see https://stripe.com/docs/api#subscription_object-tax_percent
     */
    private $taxPercent;

    /**
     * @var \DateTime
     *
     * If the subscription has a trial, the end of that trial
     *
     * @see https://stripe.com/docs/api#subscription_object-trial_end
     */
    private $trialEnd;

    /**
     * @var \DateTime
     *
     * If the subscription has a trial, the beginning of that trial
     *
     * @see https://stripe.com/docs/api#subscription_object-trial_start
     */
    private $trialStart;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getApplicationFeePercent()
    {
        return $this->applicationFeePercent;
    }

    /**
     * @return bool
     */
    public function getCanceledAt()
    {
        return $this->canceledAt;
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
     * @return \DateTime
     */
    public function getCurrentPeriodEnd()
    {
        return $this->currentPeriodEnd;
    }

    /**
     * @return \DateTime
     */
    public function getCurrentPeriodStart()
    {
        return $this->currentPeriodStart;
    }

    /**
     * @return string|null
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @return \DateTime
     */
    public function getEndedAt()
    {
        return $this->endedAt;
    }

    /**
     * @return string
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return string
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return float
     */
    public function getTaxPercent()
    {
        return $this->taxPercent;
    }

    /**
     * @return \DateTime
     */
    public function getTrialEnd()
    {
        return $this->trialEnd;
    }

    /**
     * @return \DateTime
     */
    public function getTrialStart()
    {
        return $this->trialStart;
    }

    /**
     * @return bool
     */
    public function isCancelAtPeriodEnd()
    {
        return $this->cancelAtPeriodEnd;
    }

    /**
     * @param bool $cancelAtPeriodEnd
     *
     * @return $this
     */
    public function setCancelAtPeriodEnd($cancelAtPeriodEnd)
    {
        $this->cancelAtPeriodEnd = $cancelAtPeriodEnd;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLivemode()
    {
        return $this->livemode;
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
     * @param float $applicationFeePercent
     *
     * @return $this
     */
    public function setApplicationFeePercent($applicationFeePercent)
    {
        $this->applicationFeePercent = $applicationFeePercent;

        return $this;
    }

    /**
     * @param int $quantity
     *
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @param string $plan
     *
     * @return $this
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * @param string $source
     *
     * @return $this
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @param array|string $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
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
             * This checks a plan is set.
             */
            if (null === $this->getPlan()) {
                throw new \InvalidArgumentException('To create a Charge you need to set a Plan.');
            }

            /*
             * This checks a customer.
             */
            if (null === $this->getCustomer()) {
                throw new \InvalidArgumentException('To create a Charge you need to set an Customer.');
            }

            $return = [];

            /*
             * customer required
             *
             * The identifier of the customer to subscribe.
             *
             * @see https://stripe.com/docs/api#create_subscription-customer
             */
            if (null !== $this->getCustomer()->getId()) {
                $return['customer'] = $this->getCustomer()->getId();
            }

            /*
             * application_fee_percent optional
             *
             * A positive decimal (with at most four decimal places) between 1 and 100. This represents the percentage
             * of the subscription invoice subtotal that will be transferred to the application owner’s Stripe account.
             * The request must be made with an OAuth key in order to set an application fee percentage. For more
             * information, see the application fees
             *
             * @see https://stripe.com/docs/api#create_subscription-application_fee_percent
             */
            if (null !== $this->getApplicationFeePercent()) {
                $return['application_fee_percent'] = $this->getApplicationFeePercent();
            }

            /*
             * metadata optional
             *
             * A set of key/value pairs that you can attach to a subscription object. It can be useful for storing
             * additional information about the subscription in a structured format. This will be unset if you POST an
             * empty value.This can be unset by updating the value to null and then saving.
             *
             * @see https://stripe.com/docs/api#create_subscription-metadata
             */
            if (null !== $this->getMetadata()) {
                $return['metadata'] = $this->getMetadata();
            }

            /*
             * plan optional
             *
             * The identifier of the plan to subscribe the customer to.
             *
             * @see https://stripe.com/docs/api#create_subscription-plan
             *
             */

            if (null !== $this->getPlan()) {
                $return['plan'] = $this->getPlan();
            }

            /*
             * quantity optional, default 1
             *
             * The quantity you’d like to apply to the subscription you’re creating. For example, if your plan is
             * 10/user/month, and your customer has 5 users, you could pass 5 as the quantity to have the customer
             * charged 50 (5 x 10) monthly. If you update a subscription but don’t change the plan ID (e.g. changing
             * only the trial_end), the subscription will inherit the old subscription’s quantity attribute unless you
             * pass a new quantity parameter. If you update a subscription and change the plan ID, the new subscription
             * will not inherit the quantity attribute and will default to 1 unless you pass a quantity parameter.
             *
             * @see https://stripe.com/docs/api#create_subscription-quantity
             */

            if (null !== $this->getQuantity()) {
                $return['quantity'] = $this->getQuantity();
            }

            /*
             * tax_percent optional
             *
             * A positive decimal (with at most four decimal places) between 1 and 100. This represents the percentage
             * of the subscription invoice subtotal that will be calculated and added as tax to the final amount each
             * billing period. For example, a plan which charges $10/month with a tax_percent of 20.0 will charge $12
             * per invoice.
             *
             * @see https://stripe.com/docs/api#create_subscription-tax_percent
             */

            if (null !== $this->getTaxPercent()) {
                $return['tax_percent'] = $this->getTaxPercent();
            }

            /*
             * trial_end optional
             *
             * Unix timestamp representing the end of the trial period the customer will get before being charged for
             * the first time. If set, trial_end will override the default trial period of the plan the customer is
             * being subscribed to. The special value now can be provided to end the customer’s trial immediately.
             *
             * @see https://stripe.com/docs/api#create_subscription-trial_end
             *
             * trial_period_days
             *
             * Integer representing the number of trial period days before the customer is charged for the first time.
             * If set, trial_period_days overrides the default trial period days of the plan the customer is being
             * subscribed to.
             *
             * @see https://stripe.com/docs/api#create_subscription-trial_period_days
             *
             */

            if (null !== $this->getTrialEnd()) {
                $return['trial_end']         = $this->getTrialEnd();
                $return['trial_period_days'] = $this->getTrialEnd()->diff($this->getTrialStart())->format('%a') + 1;
            }
        } elseif ('cancel' === $action) { // Prepare the array for cancelation
            $return = [];

            /*
             * at_period_end optional, default is false
             *
             * A flag that if set to true will delay the cancellation of the subscription until the end of the current
             * period.
             *
             * @see https://stripe.com/docs/api#cancel_subscription-at_period_end
             */
            if (null !== $this->isCancelAtPeriodEnd()) {
                $return['at_period_end'] = $this->isCancelAtPeriodEnd();
            }
        }

        return $return;
    }
}
