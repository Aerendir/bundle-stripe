<?php

/*
 * This file is part of the SerendipityHQ Stripe Bundle.
 *
 * Copyright (c) Adamo Crespi <hello@aerendir.me>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Service;

use Monolog\Logger;
use Psr\Log\LoggerInterface;
use SerendipityHQ\Bundle\StripeBundle\Syncer\ChargeSyncer;
use SerendipityHQ\Bundle\StripeBundle\Syncer\CustomerSyncer;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Bundle\StripeBundle\Syncer\WebhookEventSyncer;
use Stripe\ApiResource;
use Stripe\Charge;
use Stripe\Collection;
use Stripe\Customer;
use Stripe\Error\ApiConnection;
use Stripe\Error\Authentication;
use Stripe\Error\Base;
use Stripe\Error\Card;
use Stripe\Error\InvalidRequest;
use Stripe\Error\RateLimit;
use Stripe\Event;
use Stripe\Stripe;

/**
 * Manages the Stripe's API calls.
 */
class StripeManager
{
    /** @var string $environment */
    private $environment;

    /** @var LoggerInterface $logger */
    private $logger;

    /** @var int $maxRetries How many retries should the manager has to do */
    private $maxRetries = 5;

    /** @var int $retries The current number of retries. This has to ever be less than $maxRetries */
    private $retries = 0;

    /** @var int $wait The time in seconds the manager has to wait before retrying the request */
    private $wait = 1;

    /** @var ChargeSyncer $chargeSyncer */
    private $chargeSyncer;

    /** @var CustomerSyncer $customerSyncer */
    private $customerSyncer;

    /**
     * @param string                 $secretKey
     * @param string                 $environment
     * @param LoggerInterface|Logger $logger
     * @param ChargeSyncer           $chargeSyncer
     * @param CustomerSyncer         $customerSyncer
     * @param WebhookEventSyncer     $webhookEventSyncer
     */
    public function __construct($secretKey, $environment, LoggerInterface $logger, ChargeSyncer $chargeSyncer, CustomerSyncer $customerSyncer, WebhookEventSyncer $webhookEventSyncer)
    {
        Stripe::setApiKey($secretKey);
        $this->environment = $environment;
        $this->logger = $logger instanceof Logger ? $logger->withName('StripeBundle') : $logger;
        $this->chargeSyncer = $chargeSyncer;
        $this->customerSyncer = $customerSyncer;
        $this->WebhookEventSyncer = $webhookEventSyncer;
    }

    /**
     * Method to call the Stripe Api.
     *
     * This method wraps the calls in a try / catch statement to intercept exceptions raised by the Stripe client.
     *
     * @param ApiResource $endpoint
     * @param string $action
     * @param array  $params
     *
     * @return bool|ApiResource
     */
    public function callStripe(ApiResource $endpoint, $action, $params)
    {
        try {
            $return = $endpoint::$action($params);
        } catch (Base $e) {
            $return = $this->handleException($e);

            if ('retry' === $return) {
                $return = $this->callStripe($endpoint, $action, $params);
            }
        }

        // Reset the number of retries
        $this->retries = 0;

        return $return;
    }

    /**
     * Method to call the Stripe Api.
     *
     * This method wraps the calls in a try / catch statement to intercept exceptions raised by the Stripe client.
     *
     * @param ApiResource $object
     * @param string      $method
     *
     * @return bool|ApiResource
     */
    public function callStripeObject(ApiResource $object, $method)
    {
        try {
            $return = $object->$method();
        } catch (Base $e) {
            $return = $this->handleException($e);

            if ('retry' === $return) {
                $return = $this->callStripeObject($object, $method);
            }
        }

        // Reset the number of retries
        $this->retries = 0;

        return $return;
    }

    /**
     * Method to call the Stripe Api.
     *
     * This method wraps the calls in a try / catch statement to intercept exceptions raised by the Stripe client.
     *
     * @param Collection $collection
     * @param string     $method
     * @param array      $options
     *
     * @return bool|ApiResource
     */
    public function callStripeCollection(Collection $collection, $method, $options = [])
    {
        try {
            $return = $collection->$method($options);
        } catch (Base $e) {
            $return = $this->handleException($e);

            if ('retry' === $return) {
                $return = $this->callStripeCollection($collection, $method, $options);
            }
        }

        // Reset the number of retries
        $this->retries = 0;

        return $return;
    }

    /**
     * @param StripeLocalCharge $localCharge
     *
     * @return bool
     */
    public function createCharge(StripeLocalCharge $localCharge)
    {
        // Get the object as an array
        $details = $localCharge->toStripe('create');

        $stripeCharge = $this->callStripe(Charge::class, 'create', $details);

        // If the creation failed, return false
        if (false === $stripeCharge) {
            return false;
        }

        // Set the data returned by Stripe in the LocalCustomer object
        $this->chargeSyncer->syncLocalFromStripe($localCharge, $stripeCharge);

        // The creation was successful: return true
        return true;
    }

    /**
     * @param StripeLocalCustomer $localCustomer
     *
     * @return bool
     */
    public function createCustomer(StripeLocalCustomer $localCustomer)
    {
        // Get the object as an array
        $details = $localCustomer->toStripe('create');

        /** @var Customer $stripeCustomer */
        $stripeCustomer = $this->callStripe(Customer::class, 'create', $details);

        // If the creation failed, return false
        if (false === $stripeCustomer) {
            return false;
        }

        // Set the data returned by Stripe in the LocalCustomer object
        $this->customerSyncer->syncLocalFromStripe($localCustomer, $stripeCustomer);

        // The creation was successful: return true
        return true;
    }

    /**
     * @param StripeLocalCustomer $localCustomer
     *
     * @throws InvalidRequest
     *
     * @return bool|Customer|ApiResource
     */
    public function retrieveCustomer(StripeLocalCustomer $localCustomer)
    {
        // If no ID is set, return false
        if (null === $localCustomer->getId()) {
            return false;
        }

        // Return the stripe object that can be "false" or "Customer"
        return $this->callStripe(Customer::class, 'retrieve', $localCustomer->getId());
    }

    /**
     * @param string $eventStripeId
     *
     * @throws InvalidRequest
     *
     * @return bool|Event|ApiResource
     */
    public function retrieveEvent($eventStripeId)
    {
        // Return the stripe object that can be "false" or "Customer"
        return $this->callStripe(Event::class, 'retrieve', $eventStripeId);
    }

    /**
     * @param StripeLocalCustomer $localCustomer
     *
     * @return bool
     */
    public function updateCustomer(StripeLocalCustomer $localCustomer)
    {
        // Get the stripe object
        $stripeCustomer = $this->retrieveCustomer($localCustomer);

        // The retrieving failed: return false
        if (false === $stripeCustomer) {
            return false;
        }

        // Update the stripe object with info set in the local object
        $this->customerSyncer->syncStripeFromLocal($stripeCustomer, $localCustomer);

        // Save the customer object
        $stripeCustomer = $this->callStripeObject($stripeCustomer, 'save');

        // If the update failed, return false
        if (false === $stripeCustomer) {
            return false;
        }

        // Set the data returned by Stripe in the LocalCustomer object
        $this->customerSyncer->syncLocalFromStripe($localCustomer, $stripeCustomer);

        return true;
    }

    /**
     * @param \Exception $e
     *
     * @return bool|string Returns false in "production" if something goes wrong.
     *                     May return "retry" if rate limit is reached
     *
     * @throws ApiConnection  Only in dev and test environments
     * @throws Authentication Only in dev and test environments
     * @throws Card           Only in dev and test environments
     * @throws InvalidRequest Only in dev and test environments
     * @throws RateLimit      Only in dev and test environments
     */
    private function handleException(\Exception $e)
    {
        // If we received a rate limit exception, we have to retry with an exponential backoff
        if ($e instanceof RateLimit) {
            // If the maximum number of retries is already reached
            if ($this->retries >= $this->maxRetries) {
                goto raise;
            }

            // First, put the script on sleep
            sleep($this->wait);

            // Then we have to increment the sleep time
            $this->wait += $this->wait;

            // Increment by 1 the number of retries
            ++$this->retries;

            return 'retry';
        } elseif ($e instanceof Card) {
            if ('dev' === $this->environment || 'test' === $this->environment) {
                throw $e;
            }

            return false;
        }

        // \Stripe\Error\Authentication, \Stripe\Error\InvalidRequest and \Stripe\Error\ApiConnection are raised immediately
        raise:
        $body = $e->getJsonBody();
        $err = $body['error'];
        $message = '[' . $e->getHttpStatus() . ' - ' . $e->getJsonBody()['error']['type'] . '] ' . $e->getMessage();
        $context = [
            'status' => $e->getHttpStatus(),
            'type' => isset($err['type']) ? $err['type'] : '',
            'code' => isset($err['code']) ? $err['code'] : '',
            'param' => isset($err['param']) ? $err['param'] : '',
            'request_id' => $e->getRequestId(),
            'stripe_version' => $e->getHttpHeaders()['Stripe-Version']
        ];

        $this->logger->error($message, $context);

        if ('dev' === $this->environment || 'test' === $this->environment) {
            throw $e;
        }

        return false;
    }
}
