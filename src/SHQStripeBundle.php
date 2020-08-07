<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use SerendipityHQ\Component\ValueObjects\Email\Bridge\Doctrine\EmailType;
use SerendipityHQ\Component\ValueObjects\Money\Bridge\Doctrine\MoneyType;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * {@inheritdoc}
 */
final class SHQStripeBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $modelDir = \Safe\realpath(__DIR__ . '/Resources/config/doctrine/mappings');
        $mappings = [
            $modelDir => 'SerendipityHQ\Bundle\StripeBundle\Model',
        ];

        $container->addCompilerPass(
            $this->getXmlMappingDriver($mappings)
        );

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
     */
    private function getXmlMappingDriver(array $mappings): \Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass
    {
        return DoctrineOrmMappingsPass::createXmlMappingDriver(
            $mappings,
            ['stripe_bundle.model_manager_name'],
            'stripe_bundle.backend_orm',
            ['SHQStripeBundle' => 'SerendipityHQ\Bundle\StripeBundle\Model']
        );
    }
}
