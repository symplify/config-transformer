<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\FileSystem;

use Symfony\Component\Filesystem\Filesystem;
use Webmozart\Assert\Assert;

final class RelativeFilePathHelper
{
    public static function resolveFromDirectory(string $filePath, string $directory): string
    {
        Assert::fileExists($filePath);
        Assert::fileExists($directory);

        $normalizedFilePath = self::normalizePath($filePath);

        $filesystem = new Filesystem();
        $relativeFilePath = $filesystem->makePathRelative(
            $normalizedFilePath,
            (string) realpath($directory)
        );

        return rtrim($relativeFilePath, '/');
    }

    private static function normalizePath(string $path): string
    {
        return str_replace('\\', '/', $path);
    }
}
