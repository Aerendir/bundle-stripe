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

namespace SerendipityHQ\Bundle\StripeBundle\Util;

use function Safe\substr;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookAccountEventEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookApplicationFeeEventEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookBalanceEventEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookBitcoinEventEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookChargeEventEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookCouponEventEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookCustomerEventEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookInvoiceEventEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookInvoiceItemEventEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookOrderEventEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookOrderReturnEventEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookPingEventEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookProductEventEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookRecipientEventEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookReviewEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookSkuEventEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookSourceEventEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookTransferEventEvent;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalWebhookEvent;
use Stripe\Event;

/**
 * Guesses the kind of event received from the Stripe's API.
 *
 * Once the WebhookController has received an event, it has to be dispatched.
 * This class guesses the kind of the received event and returns a local event: this is then dispatched to the
 * application.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
final class EventGuesser
{
    /** @var string */
    private const TYPE = 'type';

    /** @var string */
    private const OBJECT = 'object';

    /** @var bool $debug Defines if the class has to operate in debug mode or not */
    private $debug = false;

    public function __construct(bool $debug)
    {
        $this->debug = $debug;
    }

    public function guess(Event $stripeEvent, StripeLocalWebhookEvent $localEventEntity): array
    {
        $pieces = $this->guessEventPieces($stripeEvent->type);

        switch ($pieces['kind']) {
            case 'account':
                $dispatchingEvent = new StripeWebhookAccountEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookAccountEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $dispatchingEvent,
                ];

            case 'application_fee':
                $dispatchingEvent = new StripeWebhookApplicationFeeEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookApplicationFeeEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $dispatchingEvent,
                ];

            case 'balance':
                $dispatchingEvent = new StripeWebhookBalanceEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookBalanceEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $dispatchingEvent,
                ];

            case 'bitcoin':
                $dispatchingEvent = new StripeWebhookBitcoinEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookBitcoinEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $dispatchingEvent,
                ];

            case 'charge':
                $dispatchingEvent = new StripeWebhookChargeEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookChargeEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $dispatchingEvent,
                ];

            case 'coupon':
                $dispatchingEvent = new StripeWebhookCouponEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookCouponEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $dispatchingEvent,
                ];

            case 'customer':
                $dispatchingEvent = new StripeWebhookCustomerEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookCustomerEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $dispatchingEvent,
                ];

            case 'invoice':
                $dispatchingEvent = new StripeWebhookInvoiceEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookInvoiceEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $dispatchingEvent,
                ];

            case 'invpiceitem':
                $dispatchingEvent = new StripeWebhookInvoiceItemEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookInvoiceItemEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $dispatchingEvent,
                ];

            case 'order':
                $dispatchingEvent = new StripeWebhookOrderEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookOrderEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $dispatchingEvent,
                ];

            case 'order_return':
                $dispatchingEvent = new StripeWebhookOrderReturnEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookOrderReturnEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $dispatchingEvent,
                ];

            case 'product':
                $dispatchingEvent = new StripeWebhookProductEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookProductEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $dispatchingEvent,
                ];

            case 'recipient':
                $dispatchingEvent = new StripeWebhookRecipientEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookRecipientEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $dispatchingEvent,
                ];

            case 'review':
                $dispatchingEvent = new StripeWebhookReviewEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookReviewEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $dispatchingEvent,
                ];

            case 'sku':
                $dispatchingEvent = new StripeWebhookSkuEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookSkuEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $dispatchingEvent,
                ];

            case 'source':
                $dispatchingEvent = new StripeWebhookSourceEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookSourceEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $dispatchingEvent,
                ];

            case 'transfer':
                $dispatchingEvent = new StripeWebhookTransferEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookTransferEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $dispatchingEvent,
                ];

            case 'ping':
                $dispatchingEvent = new StripeWebhookPingEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookPingEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $dispatchingEvent,
                ];

            default:
                if ($this->debug) {
                    throw new \RuntimeException('Event type not recognized. Maybe it is a new one or is not yet supported by the bundle. Report this issue to the GitHub Issue tracker.');
                }

                return [self::TYPE => null, self::OBJECT => null];
        }
    }

    /**
     * @param $type
     */
    public function guessEventPieces(string $type): array
    {
        /*
         * Guess the event kind.
         *
         * In an event like charge.dispute.closed, the kind is "charge".
         */
        $dotPosition = \strpos($type, '.');
        $eventKind   = substr($type, 0, $dotPosition);

        /*
         * Guess the constant of the type.
         *
         * In an event like charge.dispute.closed, the type is "DISPUTE_CLOSED".
         */
        $string    = \str_replace($eventKind . '.', '', $type);
        $string    = \str_replace('.', '_', $string);
        $eventType = \strtoupper($string);

        return [
            'kind'     => $eventKind,
            self::TYPE => $eventType,
        ];
    }
}
