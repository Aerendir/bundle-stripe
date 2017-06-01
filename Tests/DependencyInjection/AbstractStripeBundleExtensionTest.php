<?php

namespace SerendipityHQ\Bundle\StripeBundle\Tests\DependencyInjection;

use SerendipityHQ\Bundle\StripeBundle\DependencyInjection\StripeExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Tests the configuration of the bundle.
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
abstract class AbstractStripeBundleExtensionTest extends \PHPUnit_Framework_TestCase
{
    private $extension;

    /** @var ContainerBuilder */
    private $container;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->extension = new StripeExtension();

        $this->container = new ContainerBuilder();
        $this->container->registerExtension($this->extension);
    }

    /**
     * @param ContainerBuilder $container
     * @param $resource
     */
    abstract protected function loadConfiguration(ContainerBuilder $container, $resource);

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
}
