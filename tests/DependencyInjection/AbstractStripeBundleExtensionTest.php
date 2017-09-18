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

namespace SerendipityHQ\Bundle\StripeBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use SerendipityHQ\Bundle\StripeBundle\DependencyInjection\SHQStripeExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Tests the configuration of the bundle.
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
abstract class AbstractStripeBundleExtensionTest extends TestCase
{
    private $extension;

    /** @var ContainerBuilder */
    private $container;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->extension = new SHQStripeExtension();

        $this->container = new ContainerBuilder();
        $this->container->registerExtension($this->extension);
    }

    public function testDefaultConfig()
    {
        $this->loadConfiguration($this->container, 'default_config');
        $this->container->compile();

        $this::assertSame('orm', $this->container->getParameter('stripe_bundle.db_driver'));
        $this::assertSame(null, $this->container->getParameter('stripe_bundle.model_manager_name'));

        // Test secret key
        $this::assertSame('secret', $this->container->getParameter('stripe_bundle.secret_key'));

        // Test publishable key
        $this::assertSame('publishable', $this->container->getParameter('stripe_bundle.publishable_key'));

        /*
         * Test endpoint configuration
         */
        $this::assertSame('_stripe_bundle_endpoint', $this->container->getParameter('stripe_bundle.endpoint')['route_name']);
    }

    /**
     * @param ContainerBuilder $container
     * @param $resource
     */
    abstract protected function loadConfiguration(ContainerBuilder $container, $resource);
}
