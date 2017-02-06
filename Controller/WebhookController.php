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

        // Get the Event again from Stripe for security reasons
        $stripeWebhookEvent = $this->get('stripe_bundle.manager.stripe_api')->retrieveEvent($content['id']);

        // Now check the event doesn't already exist in the database
        $localWebhookEvent = $this->get('stripe_bundle.entity_manager')->getRepository('StripeBundle:StripeLocalWebhookEvent')->findOneByStripeId($stripeWebhookEvent->id);

        if (strpos($content['type'], 'deleted') !== false) {
            $objectType = ucfirst($content['data']['object']['object']);
            if ($localWebhookEvent === null) {
                $localResource = $this->get('stripe_bundle.entity_manager')
                    ->getRepository('StripeBundle:StripeLocal' . $objectType)
                    ->findOneBy(['id' => $content['data']['object']['id']]);
            }
            $this->get('stripe_bundle.syncer.' . $objectType)->removeLocal($localResource, $stripeWebhookEvent);

            return new Response('ok', 200);
        }

        if (null === $localWebhookEvent) {
            // Create the entity object (this will be persisted)
            $localWebhookEvent = new StripeLocalWebhookEvent();

            // Now sync the entity LocalWebhookEvent with the remote Stripe\Event (persisting is automatically handled)
            $this->get('stripe_bundle.syncer.webhook_event')->syncLocalFromStripe($localWebhookEvent, $stripeWebhookEvent);
        }

        // Guess the event to dispatch to the application
        $guessedDispatchingEvent = $this->get('stripe_bundle.guesser.event_guesser')->guess($stripeWebhookEvent, $localWebhookEvent);

        $this->container->get('event_dispatcher')->dispatch($guessedDispatchingEvent['type'], $guessedDispatchingEvent['object']);

        return new Response('ok', 200);
    }
}
