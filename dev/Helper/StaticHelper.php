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

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Tags\Property;
use phpDocumentor\Reflection\DocBlockFactory;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCard;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use Symfony\Component\Finder\Finder;
use Symfony\Component\String\ByteString;

class StaticHelper
{
    // Those are types that have to be removed from the array as they will be transformed by the syncers.
    private const FILTERS = [
        StripeLocalCard::class => [
            'customer' => [
                // This will be transformed into a StripeLocalCustomer object
                \phpDocumentor\Reflection\Types\String_::class,
            ],
        ],
        StripeLocalCharge::class => [
            'amount' => [
                // This will be transformed into a Money object
                \phpDocumentor\Reflection\Types\Integer::class,
            ],
            'amountRefunded' => [
                // This will be transformed into a Money object
                \phpDocumentor\Reflection\Types\Integer::class,
            ],
            'created' => [
                // This is transformed into a \DateTime object
                \phpDocumentor\Reflection\Types\Integer::class,
            ],
            'customer' => [
                // This will be transformed into a StripeLocalCustomer object
                \phpDocumentor\Reflection\Types\String_::class,
            ],
            'receiptEmail' => [
                // This is transformed into an EmailInterface object
                \phpDocumentor\Reflection\Types\String_::class,
            ],
            'source' => [
                // This is added by the command as a StripeObject may be returned by the api and it is transformed in an Array_ type that is not relevant
                \phpDocumentor\Reflection\Types\Array_::class,

            ],
        ],
        StripeLocalCustomer::class => [
            'created' => [
                // This is transformed into a \DateTime object
                \phpDocumentor\Reflection\Types\Integer::class,
            ],
            'currency' => [
                // This is transformed into a Currency object
                \phpDocumentor\Reflection\Types\String_::class,
            ],
            'defaultSource' => [
                // This is transformed into a StripeLocalCard object
                \phpDocumentor\Reflection\Types\String_::class,
                // This is added by the command as a StripeObject may be returned by the api and it is transformed in an Array_ type that is not relevant
                \phpDocumentor\Reflection\Types\Array_::class,

            ],
            'email' => [
                // This is transformed into an EmailInterface object
                \phpDocumentor\Reflection\Types\String_::class,
            ],
        ]
    ];

    public static function filterTypes(string $localModelClass, string $property, array $types):array
    {
        return array_filter($types,static function ($type) use ($localModelClass, $property) {
            if (isset(self::FILTERS[$localModelClass]) && isset(self::FILTERS[$localModelClass][$property])) {
                return false === in_array($type, self::FILTERS[$localModelClass][$property]);
            }

            return true;
        });
    }
}
