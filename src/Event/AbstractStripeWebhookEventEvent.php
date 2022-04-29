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

namespace SerendipityHQ\Bundle\StripeBundle\Event;

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalWebhookEvent;

/**
 * Abstract class to manage Charges.
 */
abstract class AbstractStripeWebhookEventEvent extends AbstractStripeEvent
{
    private StripeLocalWebhookEvent $localWebhookEvent;

    /**
     * @param StripeLocalWebhookEvent $localWebhookEvent The local entity representing the \Stripe\Event
     */
    public function __construct(StripeLocalWebhookEvent $localWebhookEvent)
    {
        $this->localWebhookEvent = $localWebhookEvent;
    }

    public function getLocalWebhookEvent(): StripeLocalWebhookEvent
    {
        return $this->localWebhookEvent;
    }
}
