<?php

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
class EventGuesser
{
    /**
     * @param Event                   $stripeEvent
     * @param StripeLocalWebhookEvent $localEventEntity
     *
     * @return array
     */
    public static function guess(Event $stripeEvent, StripeLocalWebhookEvent $localEventEntity)
    {
        $pieces = self::guessEventPieces($stripeEvent->type);

        switch ($pieces['kind']) {
            case 'account':
                $disptachingEvent = new StripeWebhookAccountEventEvent($localEventEntity);

                return [
                    'type' => constant(StripeWebhookAccountEventEvent::class . '::' . $pieces['type']),
                    'object' => $disptachingEvent
                ];
                break;

            case 'application_fee':
                $disptachingEvent = new StripeWebhookApplicationFeeEventEvent($localEventEntity);

                return [
                    'type' => constant(StripeWebhookApplicationFeeEventEvent::class . '::' . $pieces['type']),
                    'object' => $disptachingEvent
                ];
                break;

            case 'balance':
                $disptachingEvent = new StripeWebhookBalanceEventEvent($localEventEntity);

                return [
                    'type' => constant(StripeWebhookBalanceEventEvent::class . '::' . $pieces['type']),
                    'object' => $disptachingEvent
                ];
                break;

            case 'bitcoin':
                $disptachingEvent = new StripeWebhookBitcoinEventEvent($localEventEntity);

                return [
                    'type' => constant(StripeWebhookBitcoinEventEvent::class . '::' . $pieces['type']),
                    'object' => $disptachingEvent
                ];
                break;

            case 'charge':
                $disptachingEvent = new StripeWebhookChargeEventEvent($localEventEntity);

                return [
                    'type' => constant(StripeWebhookChargeEventEvent::class . '::' . $pieces['type']),
                    'object' => $disptachingEvent
                ];
                break;

            case 'coupon':
                $disptachingEvent = new StripeWebhookCouponEventEvent($localEventEntity);

                return [
                    'type' => constant(StripeWebhookCouponEventEvent::class . '::' . $pieces['type']),
                    'object' => $disptachingEvent
                ];
                break;

            case 'customer':
                $disptachingEvent = new StripeWebhookCustomerEventEvent($localEventEntity);

                return [
                    'type' => constant(StripeWebhookCustomerEventEvent::class . '::' . $pieces['type']),
                    'object' => $disptachingEvent
                ];
                break;

            case 'invoice':
                $disptachingEvent = new StripeWebhookInvoiceEventEvent($localEventEntity);

                return [
                    'type' => constant(StripeWebhookInvoiceEventEvent::class . '::' . $pieces['type']),
                    'object' => $disptachingEvent
                ];
                break;

            case 'invpiceitem':
                $disptachingEvent = new StripeWebhookInvoiceItemEventEvent($localEventEntity);

                return [
                    'type' => constant(StripeWebhookInvoiceItemEventEvent::class . '::' . $pieces['type']),
                    'object' => $disptachingEvent
                ];
                break;

            case 'order':
                $disptachingEvent = new StripeWebhookOrderEventEvent($localEventEntity);

                return [
                    'type' => constant(StripeWebhookOrderEventEvent::class . '::' . $pieces['type']),
                    'object' => $disptachingEvent
                ];
                break;

            case 'order_return':
                $disptachingEvent = new StripeWebhookOrderReturnEventEvent($localEventEntity);

                return [
                    'type' => constant(StripeWebhookOrderReturnEventEvent::class . '::' . $pieces['type']),
                    'object' => $disptachingEvent
                ];
                break;

            case 'plan':
                $disptachingEvent = new StripeWebhookPlanEventEvent($localEventEntity);

                return [
                    'type' => constant(StripeWebhookPlanEventEvent::class . '::' . $pieces['type']),
                    'object' => $disptachingEvent
                ];
                break;

            case 'product':
                $disptachingEvent = new StripeWebhookProductEventEvent($localEventEntity);

                return [
                    'type' => constant(StripeWebhookProductEventEvent::class . '::' . $pieces['type']),
                    'object' => $disptachingEvent
                ];
                break;

            case 'recipient':
                $disptachingEvent = new StripeWebhookRecipientEventEvent($localEventEntity);

                return [
                    'type' => constant(StripeWebhookRecipientEventEvent::class . '::' . $pieces['type']),
                    'object' => $disptachingEvent
                ];
                break;

            case 'sku':
                $disptachingEvent = new StripeWebhookSkuEventEvent($localEventEntity);

                return [
                    'type' => constant(StripeWebhookSkuEventEvent::class . '::' . $pieces['type']),
                    'object' => $disptachingEvent
                ];
                break;

            case 'source':
                $disptachingEvent = new StripeWebhookSourceEventEvent($localEventEntity);

                return [
                    'type' => constant(StripeWebhookSourceEventEvent::class . '::' . $pieces['type']),
                    'object' => $disptachingEvent
                ];
                break;

            case 'transfer':
                $disptachingEvent = new StripeWebhookTransferEventEvent($localEventEntity);

                return [
                    'type' => constant(StripeWebhookTransferEventEvent::class . '::' . $pieces['type']),
                    'object' => $disptachingEvent
                ];
                break;

            case 'ping':
                $disptachingEvent = new StripeWebhookPingEventEvent($localEventEntity);

                return [
                    'type' => constant(StripeWebhookPingEventEvent::class . '::' . $pieces['type']),
                    'object' => $disptachingEvent
                ];
                break;

            default:
                throw new \RuntimeException('Event type not recognized. Maybe it is a new one or is not yet supported by the bundle. Report this issue to the GitHub Issue tracker.');
        }
    }

    /**
     * @param $type
     *
     * @return array
     */
    public static function guessEventPieces($type)
    {
        /*
         * Guess the event kind.
         *
         * In an event like charge.dispute.closed, the kind is "charge".
         */
        $dotPosition = strpos($type, '.');
        $eventKind = substr($type, 0, $dotPosition);

        /*
         * Guess the constant of the type.
         *
         * In an event like charge.dispute.closed, the type is "DISPUTE_CLOSED".
         */
        $string = str_replace($eventKind . '.', '', $type);
        $string = str_replace('.', '_', $string);
        $eventType = strtoupper($string);

        return [
            'kind' => $eventKind,
            'type' => $eventType
        ];
    }
}
