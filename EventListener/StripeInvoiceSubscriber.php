<?php

namespace SerendipityHQ\Bundle\StripeBundle\EventListener;

use SerendipityHQ\Bundle\StripeBundle\Event\StripeInvoiceCancelEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeInvoiceCreateEvent;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeInvoicePayEvent;
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Manages Invoices on Stripe.
 */
class StripeInvoiceSubscriber extends AbstractStripeSubscriber
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            StripeInvoiceCreateEvent::CREATE => 'onInvoiceCreate',
            StripeInvoicePayEvent::PAY => 'onInvoicePay'
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @param StripeInvoiceCreateEvent $event
     * @param $eventName
     * @param ContainerAwareEventDispatcher|EventDispatcherInterface $dispatcher
     */
    public function onInvoiceCreate(StripeInvoiceCreateEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $localInvoice = $event->getLocalInvoice();

        $result = $this->getStripeManager()->createInvoice($localInvoice);

        // Check if something went wrong
        if (false === $result) {
            // Stop progation
            $event->setStopReason($this->getStripeManager()->getError())->stopPropagation();

            // Dispatch a failed event
            $dispatcher->dispatch(StripeInvoiceCreateEvent::FAILED, $event);

            // exit
            return;
        }

        $dispatcher->dispatch(StripeInvoiceCreateEvent::CREATED, $event);
    }

    /**
     * {@inheritdoc}
     *
     * @param StripeInvoicePayEvent $event
     * @param $eventName
     * @param ContainerAwareEventDispatcher|EventDispatcherInterface $dispatcher
     */
    public function onInvoicePay(StripeInvoicePayEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $localInvoice = $event->getLocalInvoice();

        $result = $this->getStripeManager()->payInvoice($localInvoice, true);

        // Check if something went wrong
        if (false === $result) {
            // Stop progation
            $event->setStopReason($this->getStripeManager()->getError())->stopPropagation();

            // Dispatch a failed event
            $dispatcher->dispatch(StripeInvoicePayEvent::FAILED, $event);

            // exit
            return;
        }

        $dispatcher->dispatch(StripeInvoiceCancelEvent::CANCELED, $event);
    }
}
