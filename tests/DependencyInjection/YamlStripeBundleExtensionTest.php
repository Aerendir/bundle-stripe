<?php

namespace SerendipityHQ\Bundle\StripeBundle\Tests\DependencyInjection;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
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
class YamlStripeBundleExtensionTest extends AbstractStripeBundleExtensionTest
{
    /**
     * {@inheritdoc}
     */
    protected function loadConfiguration(ContainerBuilder $container, $resource)
    {
        // Mock the Doctrine service
        $mockEntityManager = $this->getMockBuilder(EntityManagerInterface::class)->disableOriginalConstructor()->getMock();
        $mockDoctrineRegistry = $this->getMockBuilder(RegistryInterface::class)->disableOriginalConstructor()->getMock();
        $mockDoctrineRegistry->method('getManager')->willReturn($mockEntityManager);
        $container->set('doctrine', $mockDoctrineRegistry);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/Fixtures'));
        $loader->load($resource . '.yml');
    }
}
