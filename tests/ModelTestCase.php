<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Tests;

use PHPUnit\Framework\TestCase;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalResourceInterface;

/**
 * Base class to test model classes.
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
abstract class ModelTestCase extends TestCase
{
    /**
     * @param $data
     */
    public function populateModel(StripeLocalResourceInterface $resource, $data)
    {
        $reflect = new \ReflectionClass($resource);

        foreach ($reflect->getProperties() as $reflectedProperty) {
            if (isset($data[$reflectedProperty->getName()])) {
                // Set the property as accessible
                $reflectedProperty->setAccessible(true);
                $reflectedProperty->setValue($resource, $data[$reflectedProperty->getName()]);
            }
        }
    }
}
