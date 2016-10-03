<?php

/*
 * This file is part of the SerendipityHQ Stripe Bundle.
 *
 * Copyright (c) Adamo Crespi <hello@aerendir.me>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Util;

/**
 * @see https://github.com/Payum/Payum/blob/master/src/Payum/Core/Security/Util/Mask.php
 */
class Mask
{
    /**
     * @param string $value
     * @param string $maskSymbol
     * @param int    $showLast
     *
     * @return string
     */
    public static function mask($value, $maskSymbol = null, $showLast = 3)
    {
        $maskSymbol = $maskSymbol ?: 'X';
        $showLast = max(0, $showLast);

        if (mb_strlen($value) <= ($showLast + 1) * 2 || false === $showLast) {
            $showRegExpPart = '';
        } else {
            $showRegExpPart = "(?!(.){0,$showLast}$)";
        }

        return preg_replace("/(?!^.?)[^-_\s]$showRegExpPart/u", $maskSymbol, $value);
    }
}
