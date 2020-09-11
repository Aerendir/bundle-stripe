<?php

/*
 * This file is part of the Serendipity HQ Stripe Bundle.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Bundle\StripeBundle\Dev\Helper;

use Symfony\Component\String\ByteString;

class ReflectionHelper
{
    /**
     * @return array<array-key, ReflectionProperty>
     */
    public static function getLocalModelReflectedProperties(string $class): array
    {
        return (new \ReflectionClass($class))->getProperties();
    }

    /**
     * @return array<array-key, ReflectionProperty>
     */
    public static function getLocalModelProperties(string $class): array
    {
        $properties = (new \ReflectionClass($class))->getProperties();

        return \array_map(static function ($reflectedProperty): string {
            return $reflectedProperty->getName();
        }, $properties);
    }

    /**
     * @return array<array-key,string>
     */
    public static function getSdkModelProperties(string $class): array
    {
        $reflectedSdkModel  = new \ReflectionClass($class);
        $docComment         = $reflectedSdkModel->getDocComment();
        $explodedDocComment = \explode("\n", $docComment);

        $properties = [];
        foreach ($explodedDocComment as $docCommentLine) {
            if (false === \strpos($docCommentLine, '* @property')) {
                continue;
            }

            $match = [];
            \Safe\preg_match('/\$\w+/', $docCommentLine, $match);

            if (false === isset($match[0])) {
                throw new \RuntimeException(\Safe\sprintf('Impossible to extract the property name. The DocComment line is: "%s"', $docCommentLine));
            }

            $properties[] = \str_replace('$', '', $match[0]);
        }

        return \array_map(static function ($property): string {
            return (new ByteString($property))->camel();
        }, $properties);
    }
}
