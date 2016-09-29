<?php

/*
 * This file is part of the SerendipityHQ Stripe Bundle.
 *
 * Copyright (c) Adamo Crespi <hello@aerendir.me>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Event;

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCard;
use Symfony\Component\EventDispatcher\Event;

/**
 * Abstract class to manage Cards.
 */
class AbstractStripeSourceEvent extends Event
{
    /** @var StripeLocalCard $localSource */
    private $localSource;

    /**
     * @param StripeLocalCard $source
     */
    public function __construct(StripeLocalCard $source)
    {
        $this->localSource = $source;
    }

    /**
     * @return StripeLocalCard
     */
    public function getLocalSource()
    {
        return $this->localSource;
    }
}
