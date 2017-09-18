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

use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCard;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Bundle\StripeBundle\Tests\ModelTestCase;

/**
 * Tests the StripeLocalCard entity.
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
class StripeLocalCardTest extends ModelTestCase
{
    public function testStripeLocalCharge()
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

        $this::assertSame($expected['addressCity'], $resource->getAddressCity());
        $this::assertSame($expected['addressCountry'], $resource->getAddressCountry());
        $this::assertSame($expected['addressLine1'], $resource->getAddressLine1());
        $this::assertSame($expected['addressLine2'], $resource->getAddressLine2());
        $this::assertSame($expected['addressState'], $resource->getAddressState());
        $this::assertSame($expected['addressZip'], $resource->getAddressZip());
        $this::assertSame($expected['country'], $resource->getCountry());
        $this::assertSame($expected['customer'], $resource->getCustomer());
        $this::assertSame($expected['expMonth'], $resource->getExpMonth());
        $this::assertSame($expected['expYear'], $resource->getExpYear());
        $this::assertSame($expected['metadata'], $resource->getMetadata());
        $this::assertSame($expected['name'], $resource->getName());

        $mockCharge = $this->createMock(StripeLocalCharge::class);

        $this::assertSame(0, $resource->getCharges()->count());

        $resource->addCharge($mockCharge);
        $this::assertSame(1, $resource->getCharges()->count());
        $this::assertSame($mockCharge, $resource->getCharges()->first());

        $resource->removeCharge($mockCharge);
        $this::assertSame(0, $resource->getCharges()->count());

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

        $this::assertSame($expectedData['id'], $resource->getId());
        $this::assertSame($expectedData['addressLine1Check'], $resource->getAddressLine1Check());
        $this::assertSame($expectedData['addressZipCheck'], $resource->getAddressZipCheck());
        $this::assertSame($expectedData['brand'], $resource->getBrand());
        $this::assertSame($expectedData['cvcCheck'], $resource->getCvcCheck());
        $this::assertSame($expectedData['dynamicLast4'], $resource->getDynamicLast4());
        $this::assertSame($expectedData['fingerprint'], $resource->getFingerprint());
        $this::assertSame($expectedData['funding'], $resource->getFunding());
        $this::assertSame($expectedData['last4'], $resource->getLast4());
        $this::assertSame($expectedData['tokenizationMethod'], $resource->getTokenizationMethod());
        $this::assertSame($expectedData['id'], $resource->__toString());

        $this::expectException(\RuntimeException::class);
        $resource->toStripe('create');
    }
}
