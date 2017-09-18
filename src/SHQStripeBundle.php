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

namespace SerendipityHQ\Bundle\StripeBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use SerendipityHQ\Component\ValueObjects\Email\Persistence\EmailType;
use SerendipityHQ\Component\ValueObjects\Money\Persistence\MoneyType;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * {@inheritdoc}
 */
class SHQStripeBundle extends Bundle
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

        // Register Value Object custom types
        $container->loadFromExtension('doctrine', [
            'dbal' => [
                'types' => [
                    'email' => EmailType::class,
                    'money' => MoneyType::class,
                ],
            ],
        ]);
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
            ['SHQStripeBundle' => 'SerendipityHQ\Bundle\StripeBundle\Model']
        );
    }
}
