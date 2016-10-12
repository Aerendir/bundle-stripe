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

use Stripe\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * {@inheritdoc}
 */
class WebHookController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function NotifyAction(Request $request)
    {
        /** @var Event $content */
        $content = json_decode($request->getContent(), true);



        /*
        $this->container->get('event_dispatcher')->dispatch(
            'mrp_stripe_webhook.generic',
            new StripeWebhookEvent($event, $content)
        );
        $this->container->get('event_dispatcher')->dispatch(
            'mrp_stripe_webhook.'. $event,
            new StripeWebhookEvent($event, $content)
        );*/
        return new Response('ok', 200);
    }
}
