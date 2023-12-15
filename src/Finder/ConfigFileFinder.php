<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Finder;

use SplFileInfo;
use Symfony\Component\Finder\Finder;

final class ConfigFileFinder
{
    /**
     * @see https://regex101.com/r/jmxqCg/1
     * @var string
     */
    private const CONFIG_SUFFIXES_REGEX = '#\.(yml|yaml|xml)$#';

    /**
     * @param string[] $sources
     * @return SplFileInfo[]
     */
    public function findFileInfos(array $sources): array
    {
        $finder = new Finder();
        $finder->files()
            ->in($sources)
            ->name(self::CONFIG_SUFFIXES_REGEX);

        return iterator_to_array($finder->getIterator());
    }
}
