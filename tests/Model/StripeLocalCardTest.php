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

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCard;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Bundle\StripeBundle\Tests\ModelTestCase;

/**
 * Tests the StripeLocalCard entity.
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
final class StripeLocalCardTest extends ModelTestCase
{
    public function testStripeLocalCharge(): void
    {
        $resource = new StripeLocalCard();

        $mockCustomer = $this->createMock(StripeLocalCustomer::class);

        $expected = [
            'addressCity'    => 'nocera inferiore',
            'addressCountry' => 'Italy',
            'addressLine1'   => 'via papa giovanni XXIII, 6',
            'addressLine2'   => 'dummy line',
            'addressState'   => 'Salerno',
            'addressZip'     => '84014',
            'country'        => 'IT',
            'customer'       => $mockCustomer,
            'expMonth'       => 'nocera inferiore',
            'expYear'        => 'nocera inferiore',
            'metadata'       => 'nocera inferiore',
            'name'           => 'nocera inferiore',
        ];

        // Test setMethods
        $resource->setAddressCity($expected['addressCity'])
            ->setAddressCountry($expected['addressCountry'])
            ->setAddressLine1($expected['addressLine1'])
            ->setAddressLine2($expected['addressLine2'])
            ->setAddressState($expected['addressState'])
            ->setAddressZip($expected['addressZip'])
            ->setCountry($expected['country'])
            ->setCustomer($mockCustomer)
            ->setExpMonth($expected['expMonth'])
            ->setExpYear($expected['expYear'])
            ->setMetadata($expected['metadata'])
            ->setName($expected['name']);

        self::assertSame($expected['addressCity'], $resource->getAddressCity());
        self::assertSame($expected['addressCountry'], $resource->getAddressCountry());
        self::assertSame($expected['addressLine1'], $resource->getAddressLine1());
        self::assertSame($expected['addressLine2'], $resource->getAddressLine2());
        self::assertSame($expected['addressState'], $resource->getAddressState());
        self::assertSame($expected['addressZip'], $resource->getAddressZip());
        self::assertSame($expected['country'], $resource->getCountry());
        self::assertSame($expected['customer'], $resource->getCustomer());
        self::assertSame($expected['expMonth'], $resource->getExpMonth());
        self::assertSame($expected['expYear'], $resource->getExpYear());
        self::assertSame($expected['metadata'], $resource->getMetadata());
        self::assertSame($expected['name'], $resource->getName());

        $mockCharge = $this->createMock(StripeLocalCharge::class);

        self::assertCount(0, $resource->getCharges());

        $resource->addCharge($mockCharge);
        self::assertCount(1, $resource->getCharges());
        self::assertSame($mockCharge, $resource->getCharges()->first());

        $resource->removeCharge($mockCharge);
        self::assertCount(0, $resource->getCharges());

        $expectedData = [
            'id'                 => 'card_cardidisastring',
            'addressLine1Check'  => 'unknown',
            'addressZipCheck'    => 'unknown',
            'brand'              => 'Visa',
            'cvcCheck'           => 'unknown',
            'dynamicLast4'       => 'unknown',
            'fingerprint'        => 'iXD4WZkydnrqcdDr',
            'funding'            => 'credit',
            'last4'              => '4242',
            'tokenizationMethod' => 'unknown',
        ];
        // Populate the object
        $this->populateModel($resource, $expectedData);

        self::assertSame($expectedData['id'], $resource->getId());
        self::assertSame($expectedData['addressLine1Check'], $resource->getAddressLine1Check());
        self::assertSame($expectedData['addressZipCheck'], $resource->getAddressZipCheck());
        self::assertSame($expectedData['brand'], $resource->getBrand());
        self::assertSame($expectedData['cvcCheck'], $resource->getCvcCheck());
        self::assertSame($expectedData['dynamicLast4'], $resource->getDynamicLast4());
        self::assertSame($expectedData['fingerprint'], $resource->getFingerprint());
        self::assertSame($expectedData['funding'], $resource->getFunding());
        self::assertSame($expectedData['last4'], $resource->getLast4());
        self::assertSame($expectedData['tokenizationMethod'], $resource->getTokenizationMethod());
        self::assertSame($expectedData['id'], $resource->__toString());

        self::expectException(\RuntimeException::class);
        $resource->toStripe('create');
    }
}
