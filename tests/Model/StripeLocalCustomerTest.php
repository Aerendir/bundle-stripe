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
final class StripeLocalCustomerTest extends ModelTestCase
{
    public function testStripeLocalCustomer(): void
    {
        $resource = new StripeLocalCustomer();

        $mockEmail = $this->createMock(Email::class);
        $mockEmail->method('getEmail')->willReturn('test@example.com');

        $expected = [
            'accountBalance' => 100,
            'businessVatId'  => 'IT1234567890',
            'currency'       => 'EUR',
            'description'    => 'dummy description',
            'email'          => $mockEmail,
            'metadata'       => ['metadata'],
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

        self::assertSame($expected['accountBalance'], $resource->getAccountBalance());
        self::assertSame($expected['businessVatId'], $resource->getBusinessVatId());
        self::assertSame($expected['currency'], $resource->getCurrency());
        self::assertSame($expected['description'], $resource->getDescription());
        self::assertSame($expected['email'], $resource->getEmail());
        self::assertSame($expected['metadata'], $resource->getMetadata());
        self::assertSame($expected['source'], $resource->getNewSource());

        $mockCharge = $this->createMock(StripeLocalCharge::class);

        self::assertCount(0, $resource->getCharges());

        $resource->addCharge($mockCharge);
        self::assertCount(1, $resource->getCharges());
        self::assertSame($mockCharge, $resource->getCharges()->first());

        $resource->removeCharge($mockCharge);
        self::assertCount(0, $resource->getCharges());

        $mockCard  = $this->createMock(StripeLocalCard::class);
        $mockCards = $this->createMock(ArrayCollection::class);

        $expectedData = [
            'id'            => 'cus_customeridisastring',
            'cards'         => $mockCards,
            'created'       => $this->createMock(\DateTime::class),
            'defaultSource' => $mockCard,
            'delinquent'    => false,
            'livemode'      => false,
        ];

        // Populate the object
        $this->populateModel($resource, $expectedData);

        self::assertSame($expectedData['id'], $resource->getId());
        self::assertSame($expectedData['id'], $resource->__toString());
        self::assertSame($expectedData['cards'], $resource->getCards());
        self::assertSame($expectedData['created'], $resource->getCreated());
        self::assertSame($expectedData['defaultSource'], $resource->getDefaultSource());
        self::assertFalse($resource->isDelinquent());
        self::assertFalse($resource->isLivemode());

        $expectedToStripeCreate = [
            'account_balance' => $expected['accountBalance'],
            'business_vat_id' => $expected['businessVatId'],
            'description'     => $expected['description'],
            'email'           => 'test@example.com',
            'metadata'        => $expected['metadata'],
            'source'          => $expected['source'],
        ];
        self::assertSame($expectedToStripeCreate, $resource->toStripe('create'));
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
