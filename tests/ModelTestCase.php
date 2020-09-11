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

namespace SerendipityHQ\Bundle\StripeBundle\Tests;

use PHPUnit\Framework\TestCase;
use SerendipityHQ\Bundle\StripeBundle\Dev\Helper\ReflectionHelper;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalResourceInterface;

/**
 * Base class to test model classes.
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
abstract class ModelTestCase extends TestCase
{
    /**
     * @param array<string, mixed> $data
     */
    public function populateModel(StripeLocalResourceInterface $resource, array $data): void
    {
        $resourceProperties = ReflectionHelper::getLocalModelReflectedProperties(\get_class($resource));

        foreach ($resourceProperties as $reflectedProperty) {
            if (isset($data[$reflectedProperty->getName()])) {
                // Set the property as accessible
                $reflectedProperty->setAccessible(true);
                $reflectedProperty->setValue($resource, $data[$reflectedProperty->getName()]);
            }
        }
    }
}
