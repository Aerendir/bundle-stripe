<?php

declare(strict_types = 1);

use Rector\Config\RectorConfig;
use SerendipityHQ\Integration\Rector\SerendipityHQ;
use Rector\Core\ValueObject\PhpVersion;

return static function (RectorConfig $rectorConfig) : void {
    $rectorConfig->phpVersion(PhpVersion::PHP_74);
    $rectorConfig->paths([
        __DIR__ . '/dev',
        __DIR__ . '/src',
        // This causes issues with controllers
        // Until required for tests, keep it commented
        // __DIR__ . '/tests'
    ]);

    // This causes issues with controllers
    // Until required for tests, keep it commented
    // $rectorConfig->bootstrapFiles([__DIR__ . '/vendor-bin/phpunit/vendor/autoload.php']);
    $rectorConfig->import(SerendipityHQ::SHQ_SYMFONY_BUNDLE);

    $toSkip = SerendipityHQ::buildToSkip(SerendipityHQ::SHQ_SYMFONY_BUNDLE_SKIP);
    $rectorConfig->skip($toSkip);
};
