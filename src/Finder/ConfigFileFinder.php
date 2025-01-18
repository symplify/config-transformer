<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Finder;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

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
        $fileInfos = [];
        $directories = [];

        foreach ($sources as $source) {
            if (is_file($source)) {
                $fileInfos[] = new SplFileInfo(realpath($source), $source, $source);
            } else {
                $directories[] = $source;
            }
        }

        $finder = new Finder();
        $finder->files()
            ->in($directories)
            ->notPath('serializer')
            ->name(self::CONFIG_SUFFIXES_REGEX)
            ->append($fileInfos);

        return iterator_to_array($finder->getIterator());
    }
}
