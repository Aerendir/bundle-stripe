<?php

/*
 * This file is part of the SerendipityHQ Stripe Bundle.
 *
 * Copyright (c) Adamo Crespi <hello@aerendir.me>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * {@inheritdoc}
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * The list of supported ORM drivers.
     *
     * @return array
     */
    public static function getSupportedDrivers()
    {
        return ['orm'];
    }

    /**
     * The list of supported protocols.
     *
     * @return array
     */
    public static function getSupportedProtocols()
    {
        return ['HTTP', 'HTTPS', 'http', 'https'];
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('stripe');

        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->validate()
                        ->ifNotInArray(self::getSupportedDrivers())
                        ->thenInvalid('The driver %s is not supported. Please choose one of ' . json_encode(self::getSupportedDrivers()))
                    ->end()
                    ->cannotBeOverwritten()
                    ->defaultValue('orm')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('model_manager_name')->defaultNull()->end()
                ->arrayNode('stripe_config')
                    ->isRequired()
                    ->children()
                        ->scalarNode('secret_key')->cannotBeEmpty()->end()
                        ->scalarNode('publishable_key')->cannotBeEmpty()->end()
                    ->end()
                ->end()
                ->arrayNode('endpoint')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('route_name')->defaultValue('_stripe_bundle_endpoint')->cannotBeEmpty()->end()
                        ->scalarNode('protocol')
                        ->validate()
                        ->ifNotInArray(self::getSupportedProtocols())
                        ->thenInvalid('The protocol %s is not supported. Please choose one of ' . json_encode(self::getSupportedProtocols()))->end()
                        ->defaultValue('http')->cannotBeEmpty()
                        ->end()
                        ->scalarNode('host')->isRequired()->cannotBeEmpty()->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }
}
