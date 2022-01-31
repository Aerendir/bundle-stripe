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

namespace SerendipityHQ\Bundle\StripeBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use function Safe\json_decode;
use function Safe\sprintf;
use SerendipityHQ\Bundle\StripeBundle\Manager\StripeManager;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalResourceInterface;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalWebhookEvent;
use SerendipityHQ\Bundle\StripeBundle\Repository\StripeLocalWebhookEventRepository;
use SerendipityHQ\Bundle\StripeBundle\Syncer\CardSyncer;
use SerendipityHQ\Bundle\StripeBundle\Syncer\ChargeSyncer;
use SerendipityHQ\Bundle\StripeBundle\Syncer\CustomerSyncer;
use SerendipityHQ\Bundle\StripeBundle\Syncer\SyncerInterface;
use SerendipityHQ\Bundle\StripeBundle\Syncer\WebhookEventSyncer;
use SerendipityHQ\Bundle\StripeBundle\Util\EventGuesser;
use Stripe\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class WebhookController extends AbstractController
{
    /** @var string */
    private const ID = 'id';

    /** @var string */
    private const OBJECT = 'object';

    public function notifyAction(
        Request $request,
        EntityManagerInterface $entityManager,
        EventDispatcherInterface $eventDispatcher,
        StripeManager $stripeManager,
        EventGuesser $eventGuesser,
        CardSyncer $cardSyncer,
        ChargeSyncer $chargeSyncer,
        CustomerSyncer $customerSyncer,
        WebhookEventSyncer $webhookEventSyncer
    ): Response {
        /** @var Event $content */
        $content = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        // Get the Event again from Stripe for security reasons
        $stripeWebhookEvent = $stripeManager->retrieveEvent($content[self::ID]);

        /** @var StripeLocalWebhookEventRepository $repo */
        $repo = $entityManager->getRepository(StripeLocalWebhookEvent::class);

        // Now check the event doesn't already exist in the database
        $localWebhookEvent = $repo->findOneByStripeId($stripeWebhookEvent->id);

        if (false !== \strpos($content['type'], 'deleted')) {
            $objectType    = \ucfirst($content['data'][self::OBJECT][self::OBJECT]);
            $localResource = null;
            if ( ! $localWebhookEvent instanceof StripeLocalResourceInterface) {
                $localResource = $entityManager
                    ->getRepository(sprintf('SerendipityHQ\Bundle\StripeBundle\Model\StripeLocal%s', $objectType))
                    ->findOneBy([self::ID => $content['data'][self::OBJECT][self::ID]]);
            }

            if (null !== $localResource) {
                /** @var SyncerInterface|null $syncer */
                $syncer = null;
                switch ($objectType) {
                    case 'card':
                        $syncer = $cardSyncer;

                        break;
                    case 'charge':
                        $syncer = $chargeSyncer;

                        break;
                    case 'customer':
                        $syncer = $customerSyncer;

                        break;
                }

                if (null === $syncer) {
                    throw new \RuntimeException(sprintf('There is no syncer configured for object of type "%s".', $objectType));
                }

                if (\method_exists($syncer, 'removeLocal')) {
                    $syncer->removeLocal($localResource);
                }
            }

            return new Response('ok', 200);
        }

        if (null === $localWebhookEvent) {
            // Create the entity object (this will be persisted)
            $localWebhookEvent = new StripeLocalWebhookEvent();

            // Now sync the entity LocalWebhookEvent with the remote Stripe\Event (persisting is automatically handled)
            $webhookEventSyncer->syncLocalFromStripe($localWebhookEvent, $stripeWebhookEvent);
        }

        // Guess the event to dispatch to the application
        $guessedDispatchingEvent = $eventGuesser->guess($stripeWebhookEvent, $localWebhookEvent);

        $eventDispatcher->dispatch($guessedDispatchingEvent['type'], $guessedDispatchingEvent[self::OBJECT]);

        return new Response('ok', 200);
    }
}
