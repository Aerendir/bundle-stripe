<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Controller;

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalWebhookEvent;
use Stripe\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * {@inheritdoc}
 */
final class WebhookController extends AbstractController
{
    /**
     * @var string
     */
    private const ID = 'id';
    /**
     * @var string
     */
    private const OBJECT = 'object';

    /**
     * @param Request $request
     */
    public function notifyAction(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        /** @var Event $content */
        $content = \Safe\json_decode($request->getContent(), true);

        // Get the Event again from Stripe for security reasons
        $stripeWebhookEvent = $this->get('stripe_bundle.manager.stripe_api')->retrieveEvent($content[self::ID]);

        // Now check the event doesn't already exist in the database
        $localWebhookEvent = $this->get('stripe_bundle.entity_manager')->getRepository('SHQStripeBundle:StripeLocalWebhookEvent')->findOneByStripeId($stripeWebhookEvent->id);

        if (false !== \strpos($content['type'], 'deleted')) {
            $objectType = \ucfirst($content['data'][self::OBJECT][self::OBJECT]);
            if (null === $localWebhookEvent) {
                $localResource = $this->get('stripe_bundle.entity_manager')
                    ->getRepository('SHQStripeBundle:StripeLocal' . $objectType)
                    ->findOneBy([self::ID => $content['data'][self::OBJECT][self::ID]]);
            }
            $syncer = $this->get('stripe_bundle.syncer.' . $objectType);
            if (\method_exists($syncer, 'removeLocal')) {
                $this->get('stripe_bundle.syncer.' . $objectType)->removeLocal($localResource, $stripeWebhookEvent);
            }

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

        $this->container->get('event_dispatcher')->dispatch($guessedDispatchingEvent['type'], $guessedDispatchingEvent[self::OBJECT]);

        return new Response('ok', 200);
    }
}
