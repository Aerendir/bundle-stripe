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

namespace SerendipityHQ\Bundle\StripeBundle\Subscriber;

use SerendipityHQ\Bundle\StripeBundle\Manager\StripeManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Manages Charges on Stripe.
 */
abstract class AbstractStripeSubscriber implements EventSubscriberInterface
{
    /** @var StripeManager $stripeManager */
    private $stripeManager;

    public function __construct(StripeManager $stripeManager)
    {
        $this->stripeManager = $stripeManager;
    }

    public function getStripeManager(): StripeManager
    {
        return $this->stripeManager;
    }
}
