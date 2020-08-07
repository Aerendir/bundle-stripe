<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Event;

/**
 * Dispatched when a Cusrtomer has to be updated.
 */
final class StripeCustomerUpdateEvent extends AbstractStripeCustomerEvent
{
    /**
     * @var string
     */
    const UPDATE  = 'stripe.local.customer.update';
    /**
     * @var string
     */
    const UPDATED = 'stripe.local.customer.updated';
    /**
     * @var string
     */
    const FAILED  = 'stripe.local.customer.update_failed';

    /** @var bool */
    private $syncSources = true;

    public function hasToSyncSources(): bool
    {
        return $this->syncSources;
    }

    /**
     * Delete the sources that don't exist anymore on the remote Stripe Account.
     */
    public function syncSources(): void
    {
        $this->syncSources = true;
    }

    /**
     * Don't delete the sources that don't exists anymore on the remote Stripe Account.
     */
    public function notSyncSources(): void
    {
        $this->syncSources = false;
    }
}
