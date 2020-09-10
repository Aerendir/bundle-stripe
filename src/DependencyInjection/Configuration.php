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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * The list of supported ORM drivers.
     */
    public static function getSupportedDrivers(): array
    {
        return ['orm'];
    }

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('shq_stripe');
        $rootNode    = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->booleanNode('debug')->end()
                ->scalarNode('db_driver')
                    ->validate()
                        ->ifNotInArray(self::getSupportedDrivers())
                        ->thenInvalid('The driver %s is not supported. Please choose one of ' . json_encode(self::getSupportedDrivers()))
                    ->end()
                    ->cannotBeOverwritten()
                    ->defaultValue('orm')
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('stripe_config')
                    ->isRequired()
                    ->children()
                        ->scalarNode('secret_key')->cannotBeEmpty()->end()
                        ->scalarNode('publishable_key')->cannotBeEmpty()->end()
                        ->scalarNode('statement_descriptor')->defaultNull()->end()
                    ->end()
                ->end()
                ->arrayNode('endpoint')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('route_name')->defaultValue('_stripe_bundle_endpoint')->cannotBeEmpty()->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }
}
