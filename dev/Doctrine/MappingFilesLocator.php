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

namespace SerendipityHQ\Bundle\StripeBundle\Dev\Doctrine;

use Doctrine\Persistence\Mapping\Driver\FileLocator;
use Doctrine\Persistence\Mapping\MappingException;


class MappingFilesLocator implements FileLocator
{
    /** File extension that is searched for. */
    protected string $fileExtension;

    private string $path;

    public function __construct(string $path, string $fileExtension)
    {
        $this->path          = $path;
        $this->fileExtension = $fileExtension;
    }

    public function getPaths(): array
    {
        return [$this->path];
    }

    public function getFileExtension(): string
    {
        return $this->fileExtension;
    }

    public function fileExists($className): void
    {
        throw new \RuntimeException('Not implemented');
    }

    public function getAllClassNames($globalBasename = null): void
    {
        throw new \RuntimeException('Not implemented');
    }

    public function findMappingFile($className): string
    {
        $explodedClassName = \explode('\\', $className);
        $entityName        = \end($explodedClassName);
        $entityFile        = $this->path . $entityName . $this->fileExtension;

        if (false === \is_file($entityFile)) {
            throw MappingException::mappingFileNotFound($className, substr($className, \strrpos($className, '\\') + 1) . $this->fileExtension);
        }

        return $entityFile;
    }
}
