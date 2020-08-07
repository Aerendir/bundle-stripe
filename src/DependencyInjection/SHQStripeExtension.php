<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * {@inheritdoc}
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
final class SHQStripeExtension extends Extension
{
    /**
     * @var string
     */
    private const DB_DRIVER = 'db_driver';
    /**
     * @var string
     */
    private const STRIPE_CONFIG = 'stripe_config';
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $debug = $config['debug'] ?? $container->getParameter('kernel.debug');

        // Ever set the debug mode to off in production
        if ($container->hasParameter('kernel.environment') && 'prod' === $container->getParameter('kernel.environment')) {
            $debug = false;
        }

        // Set parameters in the container
        $container->setParameter('stripe_bundle.db_driver', $config[self::DB_DRIVER]);
        $container->setParameter(\Safe\sprintf('stripe_bundle.backend_%s', $config[self::DB_DRIVER]), true);
        $container->setParameter('stripe_bundle.model_manager_name', $config['model_manager_name']);
        $container->setParameter('stripe_bundle.secret_key', $config[self::STRIPE_CONFIG]['secret_key']);
        $container->setParameter('stripe_bundle.publishable_key', $config[self::STRIPE_CONFIG]['publishable_key']);
        $container->setParameter('stripe_bundle.debug', $debug);
        $container->setParameter('stripe_bundle.statement_descriptor', $config[self::STRIPE_CONFIG]['statement_descriptor']);
        $container->setParameter('stripe_bundle.endpoint', $config['endpoint']);

        $filelocator = new FileLocator(__DIR__ . '/../Resources/config');
        $xmlLoader   = new Loader\XmlFileLoader($container, $filelocator);
        $xmlLoader->load('listeners.xml');
        $xmlLoader->load('services.xml');

        // load db_driver container configuration
        $xmlLoader->load(\Safe\sprintf('%s.xml', $config[self::DB_DRIVER]));
    }
}
