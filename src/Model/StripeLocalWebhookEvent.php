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

    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPendingWebhooks(): int
    {
        return $this->pendingWebhooks;
    }

    public function getRequest(): string
    {
        return $this->request;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isLivemode(): bool
    {
        return $this->livemode;
    }

    public function setData(string $data): self
    {
        // Set data only if the property is null to avoid overwriting and preserve the immutability
        if (null === $this->data) {
            $this->data = $data;
        }

        return $this;
    }

    public function toStripe(string $action): array
    {
        throw new \BadMethodCallException('You cannot create events on Stripe. This method is disabled');
    }

    public function __toString(): string
    {
        return $this->getId();
    }
}
