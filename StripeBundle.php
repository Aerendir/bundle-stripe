<?php

/*
 * This file is part of the SerendipityHQ Stripe Bundle.
 *
 * Copyright (c) Adamo Crespi <hello@aerendir.me>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * {@inheritdoc}
 */
class StripeBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $modelDir = realpath(__DIR__ . '/Resources/config/doctrine/mappings');
        $mappings = [
            $modelDir => 'SerendipityHQ\Bundle\StripeBundle\Model',
        ];

        $ormCompilerClass = 'Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass';
        if (class_exists($ormCompilerClass)) {
            $container->addCompilerPass(
                $this->getXmlMappingDriver($mappings)
            );
        }
    }

    /**
     * @param array $mappings
     *
     * @return DoctrineOrmMappingsPass
     */
    private function getXmlMappingDriver(array $mappings)
    {
        return DoctrineOrmMappingsPass::createXmlMappingDriver(
            $mappings,
            ['stripe_bundle.model_manager_name'],
            'stripe_bundle.backend_orm',
            ['StripeBundle' => 'SerendipityHQ\Bundle\StripeBundle\Model']
        );
    }
}
