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

namespace SerendipityHQ\Bundle\StripeBundle\Dev\Helper;

use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCard;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;

class StaticHelper
{
    // Those are types that have to be removed from the array as they will be transformed by the syncers.
    private const FILTERS = [
        StripeLocalCard::class => [
            'customer' => [
                // This will be transformed into a StripeLocalCustomer object
                String_::class,
            ],
        ],
        StripeLocalCharge::class => [
            'amount' => [
                // This will be transformed into a Money object
                Integer::class,
            ],
            'amountRefunded' => [
                // This will be transformed into a Money object
                Integer::class,
            ],
            'created' => [
                // This is transformed into a \DateTime object
                Integer::class,
            ],
            'customer' => [
                // This will be transformed into a StripeLocalCustomer object
                String_::class,
            ],
            'receiptEmail' => [
                // This is transformed into an EmailInterface object
                String_::class,
            ],
            'source' => [
                // This is added by the command as a StripeObject may be returned by the api and it is transformed in an Array_ type that is not relevant
                Array_::class,
            ],
        ],
        StripeLocalCustomer::class => [
            'created' => [
                // This is transformed into a \DateTime object
                Integer::class,
            ],
            'currency' => [
                // This is transformed into a Currency object
                String_::class,
            ],
            'defaultSource' => [
                // This is transformed into a StripeLocalCard object
                String_::class,
                // This is added by the command as a StripeObject may be returned by the api and it is transformed in an Array_ type that is not relevant
                Array_::class,
            ],
            'email' => [
                // This is transformed into an EmailInterface object
                String_::class,
            ],
        ],
    ];

    public static function filterTypes(string $localModelClass, string $property, array $types): array
    {
        return \array_filter($types, static function ($type) use ($localModelClass, $property): bool {
            if (isset(self::FILTERS[$localModelClass]) && isset(self::FILTERS[$localModelClass][$property])) {
                return false === \in_array($type, self::FILTERS[$localModelClass][$property]);
            }

            return true;
        });
    }
}
