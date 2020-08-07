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

use Monolog\Logger;
use Psr\Log\LoggerInterface;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalPlan;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalSubscription;
use SerendipityHQ\Bundle\StripeBundle\Syncer\ChargeSyncer;
use SerendipityHQ\Bundle\StripeBundle\Syncer\CustomerSyncer;
use SerendipityHQ\Bundle\StripeBundle\Syncer\PlanSyncer;
use SerendipityHQ\Bundle\StripeBundle\Syncer\SubscriptionSyncer;
use SerendipityHQ\Bundle\StripeBundle\Syncer\WebhookEventSyncer;
use Stripe\ApiResource;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Error\ApiConnection;
use Stripe\Error\Authentication;
use Stripe\Error\Base;
use Stripe\Error\Card;
use Stripe\Error\InvalidRequest;
use Stripe\Error\RateLimit;
use Stripe\Event;
use Stripe\Plan;
use Stripe\Stripe;
use Stripe\Subscription;

/**
 * Manages the Stripe's API calls.
 */
final class StripeManager
{
    /**
     * @var \SerendipityHQ\Bundle\StripeBundle\Syncer\WebhookEventSyncer
     */
    public $WebhookEventSyncer;
    /** @var string $debug */
    private $debug;

    /** @var string $statementDescriptor */
    private $statementDescriptor;

    /** @var array|null $errors Saves the errors thrown by the Stripe API */
    private $error;

    /** @var LoggerInterface $logger */
    private $logger;

    /** @var int $maxRetries How many retries should the manager has to do */
    private const MAX_RETRIES = 5;

    /** @var int $retries The current number of retries. This has to ever be less than $maxRetries */
    private $retries = 0;

    /** @var int $wait The time in seconds the manager has to wait before retrying the request */
    private $wait = 1;

    /** @var ChargeSyncer $chargeSyncer */
    private $chargeSyncer;

    /** @var SubscriptionSyncer $subscriptionSyncer */
    private $subscriptionSyncer;

    /** @var PlanSyncer $planSyncer */
    private $planSyncer;

    /** @var CustomerSyncer $customerSyncer */
    private $customerSyncer;
    /**
     * @var string
     */
    private const OPTIONS = 'options';
    /**
     * @var string
     */
    private const ID = 'id';
    /**
     * @var string
     */
    private const PARAMS = 'params';
    /**
     * @var string
     */
    private const RETRY = 'retry';
    /**
     * @var string
     */
    private const CREATE = 'create';
    /**
     * @var string
     */
    private const ERROR = 'error';
    /**
     * @var string
     */
    private const TYPE = 'type';
    /**
     * @var string
     */
    private const RETRIEVE = 'retrieve';
    /**
     * @var string
     */
    private const CODE = 'code';

    /**
     * @param string                 $secretKey
     * @param string                 $debug
     * @param string                 $statementDescriptor
     * @param Logger|LoggerInterface $logger
     * @param ChargeSyncer           $chargeSyncer
     * @param SubscriptionSyncer     $subscriptionSyncer
     * @param PlanSyncer             $planSyncer
     * @param CustomerSyncer         $customerSyncer
     * @param WebhookEventSyncer     $webhookEventSyncer
     */
    public function __construct(string $secretKey, string $debug, string $statementDescriptor, LoggerInterface $logger = null, ChargeSyncer $chargeSyncer, SubscriptionSyncer $subscriptionSyncer, PlanSyncer $planSyncer, CustomerSyncer $customerSyncer, WebhookEventSyncer $webhookEventSyncer)
    {
        Stripe::setApiKey($secretKey);
        $this->debug               = $debug;
        $this->statementDescriptor = $statementDescriptor;
        $this->logger              = $logger instanceof Logger ? $logger->withName('SHQStripeBundle') : $logger;
        $this->chargeSyncer        = $chargeSyncer;
        $this->subscriptionSyncer  = $subscriptionSyncer;
        $this->planSyncer          = $planSyncer;
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
     * @param string $endpoint
     * @param string $action
     * @param array  $arguments
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
        } catch (Base $base) {
            $return = $this->handleException($base);

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
     * @param ApiResource $object
     * @param string      $method
     * @param array       $arguments
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
        } catch (Base $base) {
            $return = $this->handleException($base);

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

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return empty($this->error);
    }

    /**
     * @param StripeLocalCharge $localCharge
     */
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

    /**
     * @param StripeLocalSubscription $localSubscription
     */
    public function createSubscription(StripeLocalSubscription $localSubscription): bool
    {
        // Get the object as an array
        $params = $localSubscription->toStripe(self::CREATE);

        $arguments = [
            self::PARAMS  => $params,
            self::OPTIONS => [],
        ];

        $stripeSubscription = $this->callStripeApi(Subscription::class, self::CREATE, $arguments);

        // If the creation failed, return false
        if (false === $stripeSubscription) {
            return false;
        }

        // Set the data returned by Stripe in the LocalSubscription object
        $this->subscriptionSyncer->syncLocalFromStripe($localSubscription, $stripeSubscription);

        // The creation was successful: return true
        return true;
    }

    /**
     * @param StripeLocalSubscription $localSubscription
     */
    public function cancelSubscription(StripeLocalSubscription $localSubscription): bool
    {
        // Get the stripe object
        $stripeSubscription = $this->retrieveSubscription($localSubscription);

        // The retrieving failed: return false
        if (false === $stripeSubscription) {
            return false;
        }

        // Save the subscription object
        $stripeSubscription = $this->callStripeObject($stripeSubscription, 'cancel');
        // If the update failed, return false
        return false !== $stripeSubscription;
    }

    /**
     * @param StripeLocalCustomer $localCustomer
     */
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
     * @param StripeLocalCustomer $localCustomer
     *
     * @throws InvalidRequest
     *
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
     * @param StripeLocalPlan $localPlan
     */
    public function createPlan(StripeLocalPlan $localPlan): bool
    {
        // Get the object as an array
        $details = $localPlan->toStripe(self::CREATE);

        /** @var Plan $stripePlan */
        $stripePlan = $this->callStripeApi(Plan::class, self::CREATE, $details);

        // If the creation failed, return false
        if (false === $stripePlan) {
            return false;
        }

        // Set the data returned by Stripe in the LocalPlan object
        $this->planSyncer->syncLocalFromStripe($localPlan, $stripePlan);

        // The creation was successful: return true
        return true;
    }

    /**
     * @param StripeLocalPlan $localPlan
     *
     * @throws InvalidRequest
     *
     * @return ApiResource|bool|Plan
     */
    public function retrievePlan(StripeLocalPlan $localPlan)
    {
        // If no ID is set, return false
        if (null === $localPlan->getId()) {
            return false;
        }

        $arguments = [
            self::ID      => $localPlan->getId(),
            self::OPTIONS => [],
        ];

        // Return the stripe object that can be "false" or "Plan"
        return $this->callStripeApi(Plan::class, self::RETRIEVE, $arguments);
    }

    /**
     * @throws InvalidRequest
     *
     * @return ApiResource|bool|Collection
     */
    public function retrievePlans()
    {
        // Return the all plans
        return $this->callStripeApi(Plan::class, 'all', ['limit' => 100]);
    }

    /**
     * @param string $eventStripeId
     *
     * @throws InvalidRequest
     *
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

    /**
     * @param StripeLocalSubscription $localSubscription
     *
     * @throws InvalidRequest
     *
     * @return ApiResource|bool|Subscription
     */
    public function retrieveSubscription(StripeLocalSubscription $localSubscription)
    {
        // If no ID is set, return false
        if (null === $localSubscription->getId()) {
            return false;
        }

        $arguments = [
            self::ID      => $localSubscription->getId(),
            self::OPTIONS => [],
        ];

        // Return the stripe object that can be "false" or "Subscription"
        return $this->callStripeApi(Subscription::class, self::RETRIEVE, $arguments);
    }

    /**
     * @param StripeLocalCustomer $localCustomer
     * @param bool                $syncSources
     *
     * @return bool
     */
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
     * @param StripeLocalPlan $localPlan
     * @param bool            $syncSources
     */
    public function updatePlan(StripeLocalPlan $localPlan, bool $syncSources): bool
    {
        // Get the stripe object
        $stripePlan = $this->retrievePlan($localPlan);

        // The retrieving failed: return false
        if (false === $stripePlan) {
            return false;
        }

        // Update the stripe object with info set in the local object
        $this->planSyncer->syncStripeFromLocal($stripePlan, $localPlan);

        // Save the plan object
        $stripePlan = $this->callStripeObject($stripePlan, 'save');

        // If the update failed, return false
        if (false === $stripePlan) {
            return false;
        }

        // Set the data returned by Stripe in the LocalPlan object
        $this->planSyncer->syncLocalFromStripe($localPlan, $stripePlan);

        if (true === $syncSources) {
            $this->planSyncer->syncLocalSources($localPlan, $stripePlan);
        }

        return true;
    }

    /**
     * @param \Exception $e
     *
     * @throws ApiConnection  Only in dev and test environments
     * @throws Authentication Only in dev and test environments
     * @throws Card           Only in dev and test environments
     * @throws InvalidRequest Only in dev and test environments
     * @throws RateLimit      Only in dev and test environments
     *
     * @return bool|string Returns false in "production" if something goes wrong.
     *                     May return "retry" if rate limit is reached
     */
    private function handleException(Base $e)
    {
        switch (\get_class($e)) {
            case RateLimit::class:
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
            case Card::class:
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
            'status'         => $e->getHttpStatus(),
            self::TYPE           => $err[self::TYPE] ?? '',
            self::CODE           => $err[self::CODE] ?? '',
            'param'          => $err['param'] ?? '',
            'request_id'     => $e->getRequestId(),
            'stripe_version' => $e->getHttpHeaders()['Stripe-Version'],
        ];

        if (null === $this->logger) {
            $this->logger->error($message, $context);
        }

        // If we are in debug mode, raise the exception immediately
        if ($this->debug !== '') {
            throw $e;
        }

        // Set the error so it can be retrieved
        $this->error = [
            self::ERROR   => $err,
            'message' => $message,
            'context' => $context,
        ];

        if (isset($concatenated)) {
            $this->error['concatenated'] = $concatenated;
        }

        return false;
    }
}
