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

use SerendipityHQ\Bundle\StripeBundle\SHQStripeBundle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

final class ApiOutdatedCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'stripe:api:outdated';

    protected function configure(): void
    {
        $this->setDescription('Checks API compatibility between Stripe, this bundle and your Symfony app.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $ioWriter = new SymfonyStyle($input, $output);
        $ioWriter->title('Starting ' . self::$defaultName);

        if (false === \class_exists(HttpClient::class)) {
            $ioWriter->error(\Safe\sprintf("The Symfony HTTP client doesn't exist and it is required to run this command.\nRun \"composer req symfony/http-client\" to install it."));

            return self::FAILURE;
        }

        if (false === \class_exists(Crawler::class)) {
            $ioWriter->error(\Safe\sprintf('The Symfony DomCrawler component is not installed and it is required to run this command.
Run "composer req symfony/domcrawler" to install it.'));

            return self::FAILURE;
        }

        $apiVersions            = $this->scrapeApiVersions($ioWriter);
        $supportedApiVersionKey = \array_search(SHQStripeBundle::SUPPORTED_STRIPE_API, $apiVersions);

        if (false === $supportedApiVersionKey) {
            $ioWriter->error(\Safe\sprintf("The supported API version %s seems not a valid one: it doesn't exist in Stripe documentation.", SHQStripeBundle::SUPPORTED_STRIPE_API));

            return self::FAILURE;
        }

        $ioWriter->writeln(\Safe\sprintf('Supported API Version: %s', SHQStripeBundle::SUPPORTED_STRIPE_API));
        $ioWriter->writeln(\Safe\sprintf('Last API Version: %s', $apiVersions[0]));

        if (0 !== $supportedApiVersionKey) {
            $ioWriter->error(\Safe\sprintf('The currently supported API version is %s versions behind the last released one.', $supportedApiVersionKey));

            return self::FAILURE;
        }

        $ioWriter->success(\Safe\sprintf('The currently supported API version is even with the last released one.'));

        return self::SUCCESS;
    }

    private function scrapeApiVersions(SymfonyStyle $ioWriter): array
    {
        $client = HttpClient::create();

        $ioWriter->writeln('Calling https://stripe.com/docs/upgrades ...');
        $response = $client->request('GET', 'https://stripe.com/docs/upgrades');

        $statusCode = $response->getStatusCode();
        $ioWriter->writeln(\Safe\sprintf('Status code returned: %s', $statusCode));

        $html = $response->getContent();

        $crawler = new Crawler($html);

        $apiChangelogNode = $crawler->filter('h2#api-changelog');

        $apiChangelogValues = $apiChangelogNode->siblings()->each(static function (Crawler $node) {
            $apiVersion = $node->filter('h3')->extract(['id']);
            if (false === empty($apiVersion) && isset($apiVersion[0])) {
                return $apiVersion[0];
            }

            return null;
        });

        $apiVersions = \array_filter($apiChangelogValues);

        return \array_values($apiVersions);
    }
}
