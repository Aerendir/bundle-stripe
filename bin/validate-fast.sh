#!/usr/bin/env bash

    vendor/bin/security-checker security:check &&
    tools/php-cs-fixer fix --allow-risky yes --dry-run -v &&
    tools/phpstan analyse src -c phpstan.neon --level 2 &&
    tools/phan --progress-bar --minimum-severity 2
