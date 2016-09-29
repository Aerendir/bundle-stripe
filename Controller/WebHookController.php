<?php

/*
 * This file is part of the SerendipityHQ Stripe Bundle.
 *
 * Copyright (c) Adamo Crespi <hello@aerendir.me>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * {@inheritdoc}
 */
class WebHookController extends Controller
{
    /**
     * @return array
     */
    public function NotifyAction()
    {
        return [];
    }
}
