<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Service;

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
use SerendipityHQ\Bundle\StripeBundle\Event\StripeWebhookPlanEventEvent;
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
    private $debug;

    public function __construct(bool $debug)
    {
        $this->debug = $debug;
    }

    public function guess(Event $stripeEvent, StripeLocalWebhookEvent $localEventEntity): array
    {
        $pieces = $this->guessEventPieces($stripeEvent->type);

        switch ($pieces['kind']) {
            case 'account':
                $disptachingEvent = new StripeWebhookAccountEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookAccountEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $disptachingEvent,
                ];
                break;

            case 'application_fee':
                $disptachingEvent = new StripeWebhookApplicationFeeEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookApplicationFeeEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $disptachingEvent,
                ];
                break;

            case 'balance':
                $disptachingEvent = new StripeWebhookBalanceEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookBalanceEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $disptachingEvent,
                ];
                break;

            case 'bitcoin':
                $disptachingEvent = new StripeWebhookBitcoinEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookBitcoinEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $disptachingEvent,
                ];
                break;

            case 'charge':
                $disptachingEvent = new StripeWebhookChargeEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookChargeEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $disptachingEvent,
                ];
                break;

            case 'coupon':
                $disptachingEvent = new StripeWebhookCouponEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookCouponEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $disptachingEvent,
                ];
                break;

            case 'customer':
                $disptachingEvent = new StripeWebhookCustomerEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookCustomerEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $disptachingEvent,
                ];
                break;

            case 'invoice':
                $disptachingEvent = new StripeWebhookInvoiceEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookInvoiceEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $disptachingEvent,
                ];
                break;

            case 'invpiceitem':
                $disptachingEvent = new StripeWebhookInvoiceItemEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookInvoiceItemEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $disptachingEvent,
                ];
                break;

            case 'order':
                $disptachingEvent = new StripeWebhookOrderEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookOrderEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $disptachingEvent,
                ];
                break;

            case 'order_return':
                $disptachingEvent = new StripeWebhookOrderReturnEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookOrderReturnEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $disptachingEvent,
                ];
                break;

            case 'plan':
                $disptachingEvent = new StripeWebhookPlanEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookPlanEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $disptachingEvent,
                ];
                break;

            case 'product':
                $disptachingEvent = new StripeWebhookProductEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookProductEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $disptachingEvent,
                ];
                break;

            case 'recipient':
                $disptachingEvent = new StripeWebhookRecipientEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookRecipientEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $disptachingEvent,
                ];
                break;

            case 'review':
                $disptachingEvent = new StripeWebhookReviewEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookReviewEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $disptachingEvent,
                ];
                break;

            case 'sku':
                $disptachingEvent = new StripeWebhookSkuEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookSkuEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $disptachingEvent,
                ];
                break;

            case 'source':
                $disptachingEvent = new StripeWebhookSourceEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookSourceEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $disptachingEvent,
                ];
                break;

            case 'transfer':
                $disptachingEvent = new StripeWebhookTransferEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookTransferEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $disptachingEvent,
                ];
                break;

            case 'ping':
                $disptachingEvent = new StripeWebhookPingEventEvent($localEventEntity);

                return [
                    self::TYPE   => \constant(StripeWebhookPingEventEvent::class . '::' . $pieces[self::TYPE]),
                    self::OBJECT => $disptachingEvent,
                ];
                break;

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
    public function guessEventPieces($type): array
    {
        /*
         * Guess the event kind.
         *
         * In an event like charge.dispute.closed, the kind is "charge".
         */
        $dotPosition = \strpos($type, '.');
        $eventKind   = \Safe\substr($type, 0, $dotPosition);

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
