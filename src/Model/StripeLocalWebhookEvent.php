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
 * @author Adamo Crespi <hello@aerendir.me>
 *
 * @see https://stripe.com/docs/api#event_object
 */
class StripeLocalWebhookEvent implements StripeLocalResourceInterface
{
    /** @var string The Stripe ID of the StripeLocalWebhookEvent */
    private $id;

    /** @var \DateTime $created */
    private $created;

    /** @var string $data Hash containing data associated with the event. */
    private $data;

    /** @var bool $livemode */
    private $livemode;

    /** @var int $pendingWebhooks Number of webhooks yet to be delivered successfully (return a 20x response) to the URLs you’ve specified. */
    private $pendingWebhooks;

    /**
     * ID of the API request that caused the event.
     *
     * If null, the event was automatic (e.g. Stripe’s automatic subscription handling).
     * Request logs are available in the dashboard but currently not in the API.
     *
     * @var string
     */
    private $request;

    /** @var string $request Description of the event: e.g. invoice.created, charge.refunded, etc. */
    private $type;

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
    public function getData()
    {
        return $this->data;
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
    public function getPendingWebhooks()
    {
        return $this->pendingWebhooks;
    }

    /**
     * @return string
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isLivemode()
    {
        return $this->livemode;
    }

    /**
     * @param string $data
     *
     * @return $this
     */
    public function setData($data)
    {
        // Set data only if the property is null to avoid overwriting and preserve the immutability
        if (null === $this->data) {
            $this->data = $data;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toStripe($action)
    {
        throw new \BadMethodCallException('You cannot create events on Stripe. This method is disabled');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getId();
    }
}
