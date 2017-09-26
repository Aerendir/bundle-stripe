<?php

/*
 * This file is part of the SHQStripeBundle.
 *
 * Copyright Adamo Aerendir Crespi 2016-2017.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    Adamo Aerendir Crespi <hello@aerendir.me>
 * @copyright Copyright (C) 2016 - 2017 Aerendir. All rights reserved.
 * @license   MIT License.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Tests\Model;

use Money\Currency;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalPlan;
use SerendipityHQ\Bundle\StripeBundle\Tests\ModelTestCase;
use SerendipityHQ\Component\ValueObjects\Money\Money;

/**
 * Tests the StripeLocalPlan entity.
 */
class StripeLocalPlanTest extends ModelTestCase
{
    public function testStripeLocalPlan()
    {
        $amountExpected = ['amount' => 999, 'currency' => 'eur'];

        $currency = new Currency($amountExpected['currency']);

        $mockMoney = $this->createMock(Money::class);
        $mockMoney->method('getBaseAmount')->willReturn($amountExpected['amount']);
        $mockMoney->method('getCurrency')->willReturn($currency);

        $resource = new StripeLocalPlan();

        $expected = [
            'object'                => 'plan',
            'amount'                => $mockMoney,
            'created'               => 1483095706,
            'interval'              => 'month',
            'interval_count'        => 1,
            'livemode'              => false,
            'metadata'              => [],
            'name'                  => 'plan',
            'statement_description' => null,
            'trial_period_days'     => null,
        ];

        // Test setMethods
        $resource->setObject($expected['object'])
            ->setAmount($expected['amount'])
            ->setCreated($expected['created'])
            ->setInterval($expected['interval'])
            ->setIntervalCount($expected['interval_count'])
            ->setLivemode($expected['livemode'])
            ->setMetadata($expected['metadata'])
            ->setName($expected['name'])
            ->setStatementDescriptor($expected['statement_description'])
            ->setTrialPeriodDays($expected['trial_period_days']);

        $this::assertSame($expected['amount'], $resource->getAmount());
        $this::assertSame($expected['created'], $resource->getCreated());
        $this::assertSame($expected['interval'], $resource->getInterval());
        $this::assertSame($expected['interval_count'], $resource->getIntervalCount());
        $this::assertFalse($resource->isLivemode());
        $this::assertSame($expected['metadata'], $resource->getMetadata());
        $this::assertSame($expected['name'], $resource->getName());
        $this::assertSame($expected['statement_description'], $resource->getStatementDescriptor());
        $this::assertSame($expected['trial_period_days'], $resource->getTrialPeriodDays());

        $expectedToStripeCreate = [
            'amount'         => $amountExpected['amount'],
            'currency'       => $amountExpected['currency'],
            'object'         => $expected['object'],
            'created'        => $expected['created'],
            'interval'       => $expected['interval'],
            'interval_count' => $expected['interval_count'],
            'livemode'       => $expected['livemode'],
            'metadata'       => $expected['metadata'],
            'name'           => $expected['name'],
        ];

        $this::assertSame($expectedToStripeCreate, $resource->toStripe('create'));
    }

    public function testToStringThrowsAnExceptionWithAnInvalidAction()
    {
        $resource = new StripeLocalPlan();

        $this::expectException(\InvalidArgumentException::class);
        $resource->toStripe('not_create_or_update');
    }
}
