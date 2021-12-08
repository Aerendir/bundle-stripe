<?php

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
    ],
]);
