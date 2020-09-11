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

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalWebhookEvent;
use SerendipityHQ\Bundle\StripeBundle\Tests\ModelTestCase;

/**
 * Tests the StripeLocalWebhookEvent entity.
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
final class StripeLocalWebhookEventTest extends ModelTestCase
{
    public function testStripeLocalWebhookEvent(): void
    {
        $resource = new StripeLocalWebhookEvent();

        $expected = [
            'data' => '{"json": {"representation": "of data"}}',
        ];

        // Test setMethods
        $resource->setData($expected['data']);

        self::assertSame($expected['data'], $resource->getData());

        $expectedData = [
            'created'         => $this->createMock(\DateTime::class),
            'id'              => 'cus_customeridisastring',
            'pendingWebhooks' => 2,
            'request'         => 'unknown',
            'type'            => 'event.type',
            'livemode'        => false,
        ];

        // Populate the object
        $this->populateModel($resource, $expectedData);

        self::assertSame($expectedData['created'], $resource->getCreated());
        self::assertSame($expectedData['id'], $resource->getId());
        self::assertSame($expectedData['id'], $resource->__toString());
        self::assertSame($expectedData['pendingWebhooks'], $resource->getPendingWebhooks());
        self::assertSame($expectedData['request'], $resource->getRequest());
        self::assertSame($expectedData['type'], $resource->getType());
        self::assertFalse($resource->isLivemode());

        self::expectException(\BadMethodCallException::class);
        $resource->toStripe('');
    }

    public function testSetNewSourceThrowsAnExceptionWithAnInvalidTokenString(): void
    {
        $resource = new StripeLocalCustomer();

        self::expectException(\InvalidArgumentException::class);
        $resource->setNewSource('notok_sourceid');
    }

    public function testToStringThrowsAnExceptionWithAnInvalidAction(): void
    {
        $resource = new StripeLocalCustomer();

        self::expectException(\InvalidArgumentException::class);
        $resource->toStripe('not_create_or_update');
    }
}
