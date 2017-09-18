<?php

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
     * @param StripeLocalResourceInterface $resource
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
