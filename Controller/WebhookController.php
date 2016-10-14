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
class WebhookController extends Controller
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

        // Get the event again the Event from Stripe for security reasons
        $stripeWebhookEvent = $this->get('stripe_bundle.manager.stripe_api')->retrieveEvent($content['id']);

        // Now check the event doesn't already exist in the database
        $localWebhookEvent = $this->get('stripe_bundle.entity_manager')->getRepository('StripeBundle:StripeLocalWebhookEvent')->findOneByStripeId($stripeWebhookEvent->id);

        if (null === $localWebhookEvent) {
            // Create the entity object (this will be persisted)
            $localWebhookEvent = new StripeLocalWebhookEvent();

            // Now sync the entity LocalWebhookEvent eith the remote Stripe\Event (persisting is automatically handled)
            $this->get('stripe_bundle.syncer.webhook_event')->syncLocalFromStripe($localWebhookEvent, $stripeWebhookEvent);
        }

        // Guess the event to dispatch to the application
        $guessedDispatchingEvent = $this->get('stripe_bundle.guesser.event_guesser')->guess($stripeWebhookEvent, $localWebhookEvent);

        $this->container->get('event_dispatcher')->dispatch($guessedDispatchingEvent['type'], $guessedDispatchingEvent['object']);

        return new Response('ok', 200);
    }
}
