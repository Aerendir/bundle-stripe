<?php

declare(strict_types = 1);

use SerendipityHQ\Integration\Rector\SerendipityHQ;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;

return static function (ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_74);
    $parameters->set(Option::PATHS, [
        __DIR__ . '/dev',
        __DIR__ . '/src',
        // This causes issues with controllers
        // Until required for tests, keep it commented
        // __DIR__ . '/tests'
    ]);

    // This causes issues with controllers
    // Until required for tests, keep it commented
    //$parameters->set(Option::BOOTSTRAP_FILES, [__DIR__ . '/vendor-bin/phpunit/vendor/autoload.php']);

    $containerConfigurator->import(SerendipityHQ::SHQ_SYMFONY_BUNDLE);

    $toSkip = SerendipityHQ::buildToSkip(SerendipityHQ::SHQ_SYMFONY_BUNDLE_SKIP);
    $parameters->set(Option::SKIP, $toSkip);
};
