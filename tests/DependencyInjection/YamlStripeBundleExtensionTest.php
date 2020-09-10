<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Tests\DependencyInjection;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 *
 * {@inheritdoc}
 *
 * Loads the Yaml configuration
 */
final class YamlStripeBundleExtensionTest extends AbstractStripeBundleExtensionTest
{
    protected function loadConfiguration(ContainerBuilder $container, string $resource): void
    {
        // Mock the Doctrine service
        $mockEntityManager    = $this->createMock(EntityManagerInterface::class);
        $mockDoctrineRegistry = $this->createMock(ManagerRegistry::class);
        $mockDoctrineRegistry->method('getManager')->willReturn($mockEntityManager);
        $container->set('doctrine', $mockDoctrineRegistry);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/Fixtures'));
        $loader->load($resource . '.yaml');
    }
}
