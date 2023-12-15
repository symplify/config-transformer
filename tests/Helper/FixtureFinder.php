<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Tests\Helper;

use Iterator;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

final class FixtureFinder
{
    /**
     * @return Iterator<array<int, SplFileInfo>>
     */
    public static function yieldDirectory(string $directory, string $suffix = '*.php.inc'): Iterator
    {
        $finder = Finder::create()->in($directory)->files()->name($suffix);

        $fileInfos = iterator_to_array($finder->getIterator());

        foreach ($fileInfos as $fileInfo) {
            yield [$fileInfo];
        }
    }
}
