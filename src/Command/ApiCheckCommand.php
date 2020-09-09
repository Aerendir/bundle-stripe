<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Command\DoctrineCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ApiCheckCommand extends DoctrineCommand
{
    /** @var string */
    protected static $defaultName = 'stripe:api:check';

    protected function configure(): void
    {
        $this->setDescription('Checks API compatibility between Stripe, this bundle and your Symfony app.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $ioWriter = new SymfonyStyle($input, $output);
        $ioWriter->title('Starting ' . self::$defaultName);

        return 0;
    }
}
