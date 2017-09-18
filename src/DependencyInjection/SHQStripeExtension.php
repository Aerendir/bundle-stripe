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
class SHQStripeExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $debug = $config['debug'] ?? $container->getParameter('kernel.debug');

        // Ever set the debug mode to off in production
        if ($container->hasParameter('kernel.environment') && 'prod' === $container->getParameter('kernel.environment')) {
            $debug = false;
        }

        // Set parameters in the container
        $container->setParameter('stripe_bundle.db_driver', $config['db_driver']);
        $container->setParameter(sprintf('stripe_bundle.backend_%s', $config['db_driver']), true);
        $container->setParameter('stripe_bundle.model_manager_name', $config['model_manager_name']);
        $container->setParameter('stripe_bundle.secret_key', $config['stripe_config']['secret_key']);
        $container->setParameter('stripe_bundle.publishable_key', $config['stripe_config']['publishable_key']);
        $container->setParameter('stripe_bundle.debug', $debug);
        $container->setParameter('stripe_bundle.statement_descriptor', $config['stripe_config']['statement_descriptor']);
        $container->setParameter('stripe_bundle.endpoint', $config['endpoint']);

        $filelocator = new FileLocator(__DIR__ . '/../Resources/config');
        $xmlLoader   = new Loader\XmlFileLoader($container, $filelocator);
        $xmlLoader->load('listeners.xml');
        $xmlLoader->load('services.xml');

        // load db_driver container configuration
        $xmlLoader->load(sprintf('%s.xml', $config['db_driver']));
    }
}
