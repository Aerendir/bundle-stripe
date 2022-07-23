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
    /** @var SHQStripeExtension|null */
    private $extension;

    /** @var ContainerBuilder */
    private $container;

    protected function setUp(): void
    {
        $this->extension = new SHQStripeExtension();

        $this->container = new ContainerBuilder();
        $this->container->registerExtension($this->extension);
    }

    public function testDefaultConfig(): void
    {
        $this->loadConfiguration($this->container, 'default_config');
        $this->container->compile(true);

        self::assertSame('orm', $this->container->getParameter('stripe_bundle.db_driver'));

        // Test secret key
        self::assertSame('secret', $this->container->getParameter('stripe_bundle.secret_key'));

        // Test publishable key
        self::assertSame('publishable', $this->container->getParameter('stripe_bundle.publishable_key'));

        // Test endpoint configuration
        self::assertSame('_stripe_bundle_endpoint', $this->container->getParameter('stripe_bundle.endpoint')['route_name']);
    }

    abstract protected function loadConfiguration(ContainerBuilder $container, string $resource): void;
}
