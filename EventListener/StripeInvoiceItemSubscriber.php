<?php

namespace SerendipityHQ\Bundle\StripeBundle\EventListener;

use SerendipityHQ\Bundle\StripeBundle\Event\StripeInvoiceItemCancelEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeInvoiceItemCreateEvent;
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Manages InvoiceItems on Stripe.
 */
class StripeInvoiceItemSubscriber extends AbstractStripeSubscriber
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            StripeInvoiceItemCreateEvent::CREATE => 'onInvoiceItemCreate',
            StripeInvoiceItemCancelEvent::CANCEL => 'onInvoiceItemCancel'
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @param StripeInvoiceItemCreateEvent $event
     * @param $eventName
     * @param ContainerAwareEventDispatcher|EventDispatcherInterface $dispatcher
     */
    public function onInvoiceItemCreate(StripeInvoiceItemCreateEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $localInvoiceItem = $event->getLocalInvoiceItem();

        $result = $this->getStripeManager()->createInvoiceItem($localInvoiceItem);

        // Check if something went wrong
        if (false === $result) {
            // Stop progation
            $event->setStopReason($this->getStripeManager()->getError())->stopPropagation();

            // Dispatch a failed event
            $dispatcher->dispatch(StripeInvoiceItemCreateEvent::FAILED, $event);

            // exit
            return;
        }

        $dispatcher->dispatch(StripeInvoiceItemCreateEvent::CREATED, $event);
    }

    /**
     * {@inheritdoc}
     *
     * @param StripeInvoiceItemCancelEvent $event
     * @param $eventName
     * @param ContainerAwareEventDispatcher|EventDispatcherInterface $dispatcher
     */
    public function onInvoiceItemCancel(StripeInvoiceItemCancelEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $localInvoiceItem = $event->getLocalInvoiceItem();

        $localInvoiceItem->setCancelAtPeriodEnd(true);

        $result = $this->getStripeManager()->cancelInvoiceItem($localInvoiceItem, true);

        // Check if something went wrong
        if (false === $result) {
            // Stop progation
            $event->setStopReason($this->getStripeManager()->getError())->stopPropagation();

            // Dispatch a failed event
            $dispatcher->dispatch(StripeInvoiceItemCancelEvent::FAILED, $event);

            // exit
            return;
        }

        $dispatcher->dispatch(StripeInvoiceItemCancelEvent::CANCELED, $event);
    }
}
