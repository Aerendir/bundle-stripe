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
class StripeCustomerUpdateEvent extends AbstractStripeCustomerEvent
{
    const UPDATE  = 'stripe.local.customer.update';
    const UPDATED = 'stripe.local.customer.updated';
    const FAILED  = 'stripe.local.customer.update_failed';

    /** @var bool */
    private $syncSources = true;

    /**
     * @return bool
     */
    public function hasToSyncSources()
    {
        return $this->syncSources;
    }

    /**
     * Delete the sources that don't exist anymore on the remote Stripe Account.
     */
    public function syncSources()
    {
        $this->syncSources = true;
    }

    /**
     * Don't delete the sources that don't exists anymore on the remote Stripe Account.
     */
    public function notSyncSources()
    {
        $this->syncSources = false;
    }
}
