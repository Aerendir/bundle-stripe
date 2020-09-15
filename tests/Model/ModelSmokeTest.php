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

namespace SerendipityHQ\Bundle\StripeBundle\Tests\Model;

use SerendipityHQ\Bundle\StripeBundle\Dev\Helper\ReflectionHelper;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCard;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalWebhookEvent;
use SerendipityHQ\Bundle\StripeBundle\Tests\ModelTestCase;

final class ModelSmokeTest extends ModelTestCase
{
    private const SKIP = [
        StripeLocalCard::class => [
            'getId',
            'getBrand',
            'getCountry',
            'getCustomer',
            'getExpMonth',
            'getExpYear',
            'getFunding',
            'getLast4',
        ],
        StripeLocalCustomer::class => [
            'getId',
            'getCreated',
            'getNewSource',
        ],
        StripeLocalCharge::class => [
            'getId',
            'getAmount',
            'getCreated',
            'getPaid',
            'getStatus',
            'getAmountRefunded',
            'getBillingDetails',
            'getRefunds',
        ],
        StripeLocalWebhookEvent::class => true,

    ];

    /** @var null|array */
    private $models = null;

    protected function setUp() : void
    {
        if (null !== $this->models) {
            return;
        }

        $this->models = ReflectionHelper::getModelClasses();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testGetters():void
    {
        foreach ($this->models as $model) {
            $methods = (new \ReflectionClass($model))->getMethods();
            $methods = array_filter($methods, static function (\ReflectionMethod $method) {
                if (false === $method->isUserDefined()) {
                    return false;
                }

                if (false === strpos($method->getName(), 'get')) {
                    return false;
                }

                if (isset(self::SKIP[$method->class]) && (true === self::SKIP[$method->class] || false !== array_search($method->getName(), self::SKIP[$method->class]))) {
                    return false;
                }

                return true;
            });

            $model = new $model();

            foreach ($methods as $method) {
                $model->{$method->getName()}();
            }
        }
    }
}
