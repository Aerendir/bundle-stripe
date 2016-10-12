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

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalWebhookEvent;
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
     *
     * @return Response
     */
    public function notifyAction(Request $request)
    {
        /** @var Event $content */
        $content = json_decode($request->getContent(), true);

        // Get the event again from Stripe for security reasons
        $stripEvent = $this->get('stripe_bundle.manager.stripe_api')->retrieveEvent($content['id']);

        // Now check the event doesn't already exist in the database
        $localEvent = $this->get('stripe_bundle.entity_manager')->getRepository('StripeBundle:StripeLocalWebhookEvent')->findOneBy(['id' => $stripEvent->id]);

        if (null === $localEvent) {
            // We don't have a local event for this Stripe's event: create it
            $localEvent = new StripeLocalWebhookEvent();

            // Now sync it (persisting is automatically handled)
            $this->get('stripe_bundle.syncer.webhook_event')->syncLocalFromStripe($localEvent, $stripEvent);
        }

        //$event = $this->get('stripe_bundle.event_guesser')->guess($localEvent);

        //$this->container->get('event_dispatcher')->dispatch($event['type'], $event['object']);

        return new Response('ok', 200);
    }
}
