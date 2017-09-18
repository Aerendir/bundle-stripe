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

use Doctrine\Common\Collections\ArrayCollection;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCard;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Bundle\StripeBundle\Tests\ModelTestCase;
use SerendipityHQ\Component\ValueObjects\Email\Email;

/**
 * Tests the StripeLocalCustomer entity.
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
class StripeLocalCustomerTest extends ModelTestCase
{
    public function testStripeLocalCustomer()
    {
        $resource = new StripeLocalCustomer();

        $mockEmail = $this::createMock(Email::class);
        $mockEmail->method('getEmail')->willReturn('test@example.com');

        $expected = [
            'accountBalance' => 100,
            'businessVatId'  => 'IT1234567890',
            'currency'       => 'EUR',
            'description'    => 'dummy description',
            'email'          => $mockEmail,
            'metadata'       => 'metadata',
            'source'         => 'tok_isastring',
        ];

        // Test setMethods
        $resource->setAccountBalance($expected['accountBalance'])
            ->setBusinessVatId($expected['businessVatId'])
            ->setCurrency($expected['currency'])
            ->setDescription($expected['description'])
            ->setEmail($expected['email'])
            ->setMetadata($expected['metadata'])
            ->setNewSource($expected['source']);

        $this::assertSame($expected['accountBalance'], $resource->getAccountBalance());
        $this::assertSame($expected['businessVatId'], $resource->getBusinessVatId());
        $this::assertSame($expected['currency'], $resource->getCurrency());
        $this::assertSame($expected['description'], $resource->getDescription());
        $this::assertSame($expected['email'], $resource->getEmail());
        $this::assertSame($expected['metadata'], $resource->getMetadata());
        $this::assertSame($expected['source'], $resource->getNewSource());

        $mockCharge = $this->createMock(StripeLocalCharge::class);

        $this::assertSame(0, $resource->getCharges()->count());

        $resource->addCharge($mockCharge);
        $this::assertSame(1, $resource->getCharges()->count());
        $this::assertSame($mockCharge, $resource->getCharges()->first());

        $resource->removeCharge($mockCharge);
        $this::assertSame(0, $resource->getCharges()->count());

        $mockCard  = $this::createMock(StripeLocalCard::class);
        $mockCards = $this::createMock(ArrayCollection::class);

        $expectedData = [
            'id'            => 'cus_customeridisastring',
            'cards'         => $mockCards,
            'created'       => $this::createMock(\DateTime::class),
            'defaultSource' => $mockCard,
            'delinquent'    => false,
            'livemode'      => false,
        ];

        // Populate the object
        $this->populateModel($resource, $expectedData);

        $this::assertSame($expectedData['id'], $resource->getId());
        $this::assertSame($expectedData['id'], $resource->__toString());
        $this::assertSame($expectedData['cards'], $resource->getCards());
        $this::assertSame($expectedData['created'], $resource->getCreated());
        $this::assertSame($expectedData['defaultSource'], $resource->getDefaultSource());
        $this::assertFalse($resource->isDelinquent());
        $this::assertFalse($resource->isLivemode());

        $expectedToStripeCreate = [
            'account_balance' => $expected['accountBalance'],
            'business_vat_id' => $expected['businessVatId'],
            'description'     => $expected['description'],
            'email'           => 'test@example.com',
            'metadata'        => $expected['metadata'],
            'source'          => $expected['source'],
        ];
        $this::assertSame($expectedToStripeCreate, $resource->toStripe('create'));
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
