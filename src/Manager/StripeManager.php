<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Manager;

use Monolog\Logger;
use Psr\Log\LoggerInterface;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Bundle\StripeBundle\SHQStripeBundle;
use SerendipityHQ\Bundle\StripeBundle\Syncer\ChargeSyncer;
use SerendipityHQ\Bundle\StripeBundle\Syncer\CustomerSyncer;
use SerendipityHQ\Bundle\StripeBundle\Syncer\WebhookEventSyncer;
use Stripe\ApiResource;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Event;
use Stripe\Exception\CardException;
use Stripe\Exception\ExceptionInterface;
use Stripe\Exception\RateLimitException;
use Stripe\Stripe;

/**
 * Manages the Stripe's API calls.
 */
final class StripeManager
{
    /** @var int $maxRetries How many retries should the manager has to do */
    private const MAX_RETRIES = 5;
    /** @var string */
    private const OPTIONS = 'options';
    /** @var string */
    private const ID = 'id';
    /** @var string */
    private const PARAMS = 'params';
    /** @var string */
    private const RETRY = 'retry';
    /** @var string */
    private const CREATE = 'create';
    /** @var string */
    private const ERROR = 'error';
    /** @var string */
    private const TYPE = 'type';
    /** @var string */
    private const RETRIEVE = 'retrieve';
    /** @var string */
    private const CODE = 'code';
    /** @var WebhookEventSyncer */
    public $WebhookEventSyncer;
    /** @var string $debug */
    private $debug;

    /** @var string $statementDescriptor */
    private $statementDescriptor;

    /** @var array|null $errors Saves the errors thrown by the Stripe API */
    private $error;

    /** @var LoggerInterface $logger */
    private $logger;

    /** @var int $retries The current number of retries. This has to ever be less than $maxRetries */
    private $retries = 0;

    /** @var int $wait The time in seconds the manager has to wait before retrying the request */
    private $wait = 1;

    /** @var ChargeSyncer $chargeSyncer */
    private $chargeSyncer;

    /** @var CustomerSyncer $customerSyncer */
    private $customerSyncer;

    public function __construct(string $secretKey, string $debug, string $statementDescriptor, ChargeSyncer $chargeSyncer, CustomerSyncer $customerSyncer, WebhookEventSyncer $webhookEventSyncer, LoggerInterface $logger = null)
    {
        Stripe::setApiKey($secretKey);
        Stripe::setApiVersion(SHQStripeBundle::SUPPORTED_STRIPE_API);
        $this->debug               = $debug;
        $this->statementDescriptor = $statementDescriptor;
        $this->logger              = $logger instanceof Logger ? $logger->withName('SHQStripeBundle') : $logger;
        $this->chargeSyncer        = $chargeSyncer;
        $this->customerSyncer      = $customerSyncer;
        $this->WebhookEventSyncer  = $webhookEventSyncer;
    }

    /**
     * Method to call the Stripe PHP SDK's static methods.
     *
     * This method wraps the calls in a try / catch statement to intercept exceptions raised by the Stripe client.
     *
     * It receives three arguments:
     *
     * 1) The FQN of the Stripe Entity class;
     * 2) The method of the class to invoke;
     * 3) The arguments to pass to the method.
     *
     * As the methods of the Stripe PHP SDK have all the same structure, it is possible to extract a pattern.
     *
     * So, the alternatives are as following:
     *
     * 1) options
     * 2) id, options
     * 3) params, options
     * 4) id, params, options
     *
     * Only the case 2 and 3 are confusable.
     *
     * To make this method able to match the right Stripe SDK's method signature, always set all the required arguments.
     * If one argument is not required (only options or params are allowed to be missed), anyway set it as an empty array.
     * BUT ANYWAY SET IT to make the switch able to match the proper method signature.
     *
     * So, to call a Stripe API's entity with a method with signature that matches case 1:
     *
     *     $arguments = [
     *         'options' => [...] // Or an empty array
     *     ];
     *     $this->callStripe(Customer::class, 'save', $arguments)
     *
     * To call a Stripe API's entity with a method with signature that matches case 2:
     *
     *     $arguments = [
     *         'id' => 'the_id_of_the_entity',
     *         'options' => [...] // Or an empty array
     *     ];
     *     $this->callStripe(Customer::class, 'save', $arguments)
     *
     * To call a Stripe API's entity with a method with signature that matches case 3:
     *
     *     $arguments = [
     *         'params' => [...] // Or an empty array,
     *         'options' => [...] // Or an empty array
     *     ];
     *     $this->callStripe(Customer::class, 'save', $arguments)
     *
     * To call a Stripe API's entity with a method with signature that matches case 4:
     *
     *     $arguments = [
     *         'id' => 'the_id_of_the_entity',
     *         'params' => [...] // Or an empty array,
     *         'options' => [...] // Or an empty array
     *     ];
     *     $this->callStripe(Customer::class, 'save', $arguments)
     *
     * @return ApiResource|bool
     */
    public function callStripeApi(string $endpoint, string $action, array $arguments)
    {
        try {
            switch (\count($arguments)) {
                // Method with 1 argument only accept "options"
                case 1:
                    // If the value is an empty array, then set it as null
                    $options = empty($arguments[self::OPTIONS]) ? null : $arguments[self::OPTIONS];
                    $return  = $endpoint::$action($options);
                    break;
                case 2:
                    // If the ID exists, we have to call for sure a method that in the signature has the ID and the options
                    if (isset($arguments[self::ID])) {
                        // If the value is an empty array, then set it as null
                        $options = empty($arguments[self::OPTIONS]) ? null : $arguments[self::OPTIONS];
                        $return  = $endpoint::$action($arguments[self::ID], $options);
                    }
                    // Else the method has params and options
                    else {
                        // If the value is an empty array, then set it as null
                        $params  = empty($arguments[self::PARAMS]) ? null : $arguments[self::PARAMS];
                        $options = empty($arguments[self::OPTIONS]) ? null : $arguments[self::OPTIONS];
                        $return  = $endpoint::$action($params, $options);
                    }
                    break;
                // Method with 3 arguments accept id, params and options
                case 3:
                    // If the value is an empty array, then set it as null
                    $params  = empty($arguments[self::PARAMS]) ? null : $arguments[self::PARAMS];
                    $options = empty($arguments[self::OPTIONS]) ? null : $arguments[self::OPTIONS];
                    $return  = $endpoint::$action($arguments[self::ID], $params, $options);
                    break;
                default:
                    throw new \RuntimeException("The arguments passed don't correspond to the allowed number. Please, review them.");
            }
        } catch (ExceptionInterface $exceptionInterface) {
            $return = $this->handleException($exceptionInterface);

            if (self::RETRY === $return) {
                $return = $this->callStripeApi($endpoint, $action, $arguments);
            }
        }

        // Reset the number of retries
        $this->retries = 0;

        return $return;
    }

    /**
     * Method to call the Stripe PHP SDK's NON static methods.
     *
     * This method is usually used to call methods of a Stripe entity that is already initialized.
     *
     * For example, it can be used to call "cancel" or "save" methods after they have been retrieved through
     * $this->callStripe(...).
     *
     * This method wraps the calls in a try / catch statement to intercept exceptions raised by the Stripe client.
     *
     * It receives three arguments:
     *
     * 1) The FQN of the Stripe Entity class;
     * 2) The method of the class to invoke;
     * 3) The arguments to pass to the method.
     *
     * As the methods of the Stripe PHP SDK have all the same structure, it is possible to extract a pattern.
     *
     * So, the alternatives are as following:
     *
     * 1) options
     * 2) params, options
     * 3) params
     * 4) [No arguments]
     *
     * There are no confusable cases.
     *
     * To make this method able to match the right Stripe SDK's method signature, set all the required arguments only
     * for methods that match the case 2 and if If one argument is not required, anyway set it as an empty array BUT
     * ANYWAY SET IT to make the switch able to match the proper method signature.
     *
     * So, to call a Stripe SDK's method with signature that matches case 1 or case 3:
     *
     *     $arguments = [
     *         [...] // Or an empty array
     *     ];
     *     $this->callStripeObject(Customer::class, 'save', $arguments)
     *
     * You can give the key a name for clarity, but in the callStripeObject method it is anyway referenced to as
     * $arguments[0], so is irrelevant you give a key or not.
     *
     * To call a Stripe SDK's method with signature that matches case 2:
     *
     *     $arguments = [
     *         'params' => [...] // Or an empty array,
     *         'options' => [...] // Or an empty array
     *     ];
     *     $this->callStripeObject(Customer::class, 'cancel', $arguments)
     *
     * You can give the key a name for clarity, but in the callStripeObject method it is anyway referenced to as
     * $arguments[0], so is irrelevant you give a key or not.
     *
     * @return ApiResource|bool
     */
    public function callStripeObject(ApiResource $object, string $method, array $arguments = [])
    {
        try {
            switch (\count($arguments)) {
                // Method has no signature (it doesn't accept any argument)
                case 0:
                    $return = $object->$method();
                    break;
                // Method with 1 argument only accept one between "options" or "params"
                case 1:
                    // So we simply use the unique value in the array
                    $return = $object->$method($arguments[0]);
                    break;
                // Method with 3 arguments accept id, params and options
                case 2:
                    // If the value is an empty array, then set it as null
                    $params  = empty($arguments[self::PARAMS]) ? null : $arguments[self::PARAMS];
                    $options = empty($arguments[self::OPTIONS]) ? null : $arguments[self::OPTIONS];
                    $return  = $object->$method($params, $options);
                    break;
                default:
                    throw new \RuntimeException("The arguments passed don't correspond to the allowed number. Please, review them.");
            }
        } catch (ExceptionInterface $exceptionInterface) {
            $return = $this->handleException($exceptionInterface);

            if (self::RETRY === $return) {
                $return = $this->callStripeObject($object, $method);
            }
        }

        // Reset the number of retries
        $this->retries = 0;

        return $return;
    }

    /**
     * This should be called only if an error exists. Use hasError().
     *
     * @return array|null
     */
    public function getError(): array
    {
        return $this->error;
    }

    public function hasErrors(): bool
    {
        return empty($this->error);
    }

    public function createCharge(StripeLocalCharge $localCharge): bool
    {
        // Get the object as an array
        $params = $localCharge->toStripe(self::CREATE);

        // If the statement descriptor is not set and the default one is not null...
        if (false === isset($params['statement_descriptor']) && false === \is_null($this->statementDescriptor)) {
            // Set it
            $params['statement_descriptor'] = $this->statementDescriptor;
        }

        $arguments = [
            self::PARAMS  => $params,
            self::OPTIONS => [],
        ];

        $stripeCharge = $this->callStripeApi(Charge::class, self::CREATE, $arguments);

        // If the creation failed...
        if (false === $stripeCharge) {
            // ... Check if it was due to a fraudulent detection
            if (isset($this->error[self::ERROR][self::TYPE])) {
                $this->chargeSyncer->handleFraudDetection($localCharge, $this->error);
            }

            // ... return false as the payment anyway failed
            return false;
        }

        // Set the data returned by Stripe in the LocalCustomer object
        $this->chargeSyncer->syncLocalFromStripe($localCharge, $stripeCharge);

        // The creation was successful: return true
        return true;
    }

    public function createCustomer(StripeLocalCustomer $localCustomer): bool
    {
        // Get the object as an array
        $params = $localCustomer->toStripe(self::CREATE);

        $arguments = [
            self::PARAMS  => $params,
            self::OPTIONS => [],
        ];

        /** @var Customer $stripeCustomer */
        $stripeCustomer = $this->callStripeApi(Customer::class, self::CREATE, $arguments);

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
     * @return ApiResource|bool|Customer
     */
    public function retrieveCustomer(StripeLocalCustomer $localCustomer)
    {
        // If no ID is set, return false
        if (null === $localCustomer->getId()) {
            return false;
        }

        $arguments = [
            self::ID      => $localCustomer->getId(),
            self::OPTIONS => [],
        ];

        // Return the stripe object that can be "false" or "Customer"
        return $this->callStripeApi(Customer::class, self::RETRIEVE, $arguments);
    }

    /**
     * @return ApiResource|bool|Event
     */
    public function retrieveEvent(string $eventStripeId)
    {
        $arguments = [
            self::ID      => $eventStripeId,
            self::OPTIONS => [],
        ];

        // Return the stripe object that can be "false" or "Customer"
        return $this->callStripeApi(Event::class, self::RETRIEVE, $arguments);
    }

    public function updateCustomer(StripeLocalCustomer $localCustomer, bool $syncSources): bool
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

        if (true === $syncSources) {
            $this->customerSyncer->syncLocalSources($localCustomer, $stripeCustomer);
        }

        return true;
    }

    /**
     * @return bool|string Returns false in "production" if something goes wrong.
     *                     May return "retry" if rate limit is reached
     */
    private function handleException(ExceptionInterface $e)
    {
        switch (\get_class($e)) {
            case RateLimitException::class:
                // We have to retry with an exponential backoff if is not reached the maximum number of retries
                if ($this->retries <= self::MAX_RETRIES) {
                    // First, put the script on sleep
                    \Safe\sleep($this->wait);

                    // Then we have to increment the sleep time
                    $this->wait += $this->wait;

                    // Increment by 1 the number of retries
                    ++$this->retries;

                    return self::RETRY;
                }
                break;
            case CardException::class:
                $concatenated = 'stripe';
                if (isset($e->getJsonBody()[self::ERROR][self::TYPE])) {
                    $concatenated .= '.' . $e->getJsonBody()[self::ERROR][self::TYPE];
                }
                if (isset($e->getJsonBody()[self::ERROR][self::CODE])) {
                    $concatenated .= '.' . $e->getJsonBody()[self::ERROR][self::CODE];
                }
                if (isset($e->getJsonBody()[self::ERROR]['decline_code'])) {
                    $concatenated .= '.' . $e->getJsonBody()[self::ERROR]['decline_code'];
                }
                break;
        }

        // \Stripe\Error\Authentication, \Stripe\Error\InvalidRequest and \Stripe\Error\ApiConnection are processed immediately
        $body    = $e->getJsonBody();
        $err     = $body[self::ERROR];
        $message = '[' . $e->getHttpStatus() . ' - ' . $e->getJsonBody()[self::ERROR][self::TYPE] . '] ' . $e->getMessage();
        $context = [
            'status'             => $e->getHttpStatus(),
            self::TYPE           => $err[self::TYPE] ?? '',
            self::CODE           => $err[self::CODE] ?? '',
            'param'              => $err['param'] ?? '',
            'request_id'         => $e->getRequestId(),
            'stripe_version'     => $e->getHttpHeaders()['Stripe-Version'],
        ];

        if (null === $this->logger) {
            $this->logger->error($message, $context);
        }

        // If we are in debug mode, raise the exception immediately
        if ('' !== $this->debug) {
            throw $e;
        }

        // Set the error so it can be retrieved
        $this->error = [
            self::ERROR   => $err,
            'message'     => $message,
            'context'     => $context,
        ];

        if (isset($concatenated)) {
            $this->error['concatenated'] = $concatenated;
        }

        return false;
    }
}
