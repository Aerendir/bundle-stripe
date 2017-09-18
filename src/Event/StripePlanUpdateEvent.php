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

namespace SerendipityHQ\Bundle\StripeBundle\Event;

/**
 * Dispatched when a Cusrtomer has to be updated.
 */
class StripePlanUpdateEvent extends AbstractStripePlanEvent
{
    const UPDATE  = 'stripe.local.plan.update';
    const UPDATED = 'stripe.local.plan.updated';
    const FAILED  = 'stripe.local.plan.update_failed';

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
