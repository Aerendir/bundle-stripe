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
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('shq_stripe');

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
                ->scalarNode('model_manager_name')->defaultNull()->end()
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
