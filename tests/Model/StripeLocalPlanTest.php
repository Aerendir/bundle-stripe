<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Tests\Model;

use Money\Currency;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalPlan;
use SerendipityHQ\Bundle\StripeBundle\Tests\ModelTestCase;
use SerendipityHQ\Component\ValueObjects\Money\Money;

/**
 * Tests the StripeLocalPlan entity.
 */
final class StripeLocalPlanTest extends ModelTestCase
{
    /** @var int[]|string[] */
    private const AMOUNT_EXPECTED = ['amount' => '999', 'currency' => 'eur'];

    public function testStripeLocalPlan(): void
    {
        $currency  = new Currency(self::AMOUNT_EXPECTED['currency']);
        $mockMoney = $this->createMock(Money::class);
        $mockMoney->method('getBaseAmount')->willReturn(self::AMOUNT_EXPECTED['amount']);
        $mockMoney->method('getCurrency')->willReturn($currency);
        $resource = new StripeLocalPlan();
        $expected = [
            'object'                => 'plan',
            'amount'                => $mockMoney,
            'created'               => new \DateTime('@1483095706'),
            'interval'              => 'month',
            'interval_count'        => 1,
            'livemode'              => false,
            'metadata'              => 'metadata',
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
        self::assertSame($expected['amount'], $resource->getAmount());
        self::assertSame($expected['created'], $resource->getCreated());
        self::assertSame($expected['interval'], $resource->getInterval());
        self::assertSame($expected['interval_count'], $resource->getIntervalCount());
        self::assertFalse($resource->isLivemode());
        self::assertSame($expected['metadata'], $resource->getMetadata());
        self::assertSame($expected['name'], $resource->getName());
        self::assertSame($expected['statement_description'], $resource->getStatementDescriptor());
        self::assertSame($expected['trial_period_days'], $resource->getTrialPeriodDays());
        $expectedToStripeCreate = [
            'amount'         => self::AMOUNT_EXPECTED['amount'],
            'currency'       => self::AMOUNT_EXPECTED['currency'],
            'object'         => $expected['object'],
            'created'        => $expected['created'],
            'interval'       => $expected['interval'],
            'interval_count' => $expected['interval_count'],
            'livemode'       => $expected['livemode'],
            'metadata'       => $expected['metadata'],
            'name'           => $expected['name'],
        ];
        self::assertSame($expectedToStripeCreate, $resource->toStripe('create'));
    }

    public function testToStringThrowsAnExceptionWithAnInvalidAction(): void
    {
        $resource = new StripeLocalPlan();

        self::expectException(\InvalidArgumentException::class);
        $resource->toStripe('not_create_or_update');
    }
}
