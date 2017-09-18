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

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalWebhookEvent;
use SerendipityHQ\Bundle\StripeBundle\Tests\ModelTestCase;

/**
 * Tests the StripeLocalWebhookEvent entity.
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
class StripeLocalWebhookEventTest extends ModelTestCase
{
    public function testStripeLocalWebhookEvent()
    {
        $resource = new StripeLocalWebhookEvent();

        $expected = [
            'data' => '{"json": {"representation": "of data"}}',
        ];

        // Test setMethods
        $resource->setData($expected['data']);

        $this::assertSame($expected['data'], $resource->getData());

        $expectedData = [
            'created'         => $this::createMock(\DateTime::class),
            'id'              => 'cus_customeridisastring',
            'pendingWebhooks' => 2,
            'request'         => 'unknown',
            'type'            => 'event.type',
            'livemode'        => false,
        ];

        // Populate the object
        $this->populateModel($resource, $expectedData);

        $this::assertSame($expectedData['created'], $resource->getCreated());
        $this::assertSame($expectedData['id'], $resource->getId());
        $this::assertSame($expectedData['id'], $resource->__toString());
        $this::assertSame($expectedData['pendingWebhooks'], $resource->getPendingWebhooks());
        $this::assertSame($expectedData['request'], $resource->getRequest());
        $this::assertSame($expectedData['type'], $resource->getType());
        $this::assertFalse($resource->isLivemode());

        $this::expectException(\BadMethodCallException::class);
        $resource->toStripe('');
    }

    public function testSetNewSourceThrowsAnExceptionWithAnInvalidTokenString()
    {
        $resource = new StripeLocalCustomer();

        $this::expectException(\InvalidArgumentException::class);
        $resource->setNewSource('notok_sourceid');
    }

    public function testToStringThrowsAnExceptionWithAnInvalidAction()
    {
        $resource = new StripeLocalCustomer();

        $this::expectException(\InvalidArgumentException::class);
        $resource->toStripe('not_create_or_update');
    }
}
