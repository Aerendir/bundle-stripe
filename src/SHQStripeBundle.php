<?php

declare(strict_types=1);

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
use SerendipityHQ\Component\ValueObjects\Currency\Bridge\Doctrine\CurrencyType;
use SerendipityHQ\Component\ValueObjects\Email\Bridge\Doctrine\EmailType;
use SerendipityHQ\Component\ValueObjects\Money\Bridge\Doctrine\MoneyType;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use function Safe\realpath;

final class SHQStripeBundle extends Bundle
{
    public const SUPPORTED_STRIPE_API = '2020-08-27';

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $modelDir = realpath(__DIR__ . '/Resources/config/doctrine/mappings');
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
                    'currency' => CurrencyType::class,
                    'email'    => EmailType::class,
                    'money'    => MoneyType::class,
                ],
            ],
        ]);
    }

    private function getXmlMappingDriver(array $mappings): DoctrineOrmMappingsPass
    {
        return DoctrineOrmMappingsPass::createXmlMappingDriver(
            $mappings,
            ['stripe_bundle.model_manager_name'],
            'stripe_bundle.backend_orm',
            ['SHQStripeBundle' => 'SerendipityHQ\Bundle\StripeBundle\Model']
        );
    }
}
