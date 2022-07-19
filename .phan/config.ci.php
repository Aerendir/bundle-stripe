<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return array_merge(require_once 'config.php', [
    'suppress_issue_types' => [
        'PhanRedefinedClassReference',
        'PhanRedefinedExtendedClass',
        // Causes issue with SF < 5
        'PhanParamTooMany',
        // Manually added baseline
        'PhanTypeMismatchArgument',
        // Causes some issues with ChargeSyncer
        'PhanTypeMismatchArgumentSuperType',
        'PhanUnreferencedClass',
    ],
]);
