<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Finder;

use Symfony\Component\Finder\Finder;
use Symplify\SmartFileSystem\FileSystemFilter;
use Symplify\SmartFileSystem\Finder\FinderSanitizer;
use Symplify\SmartFileSystem\SmartFileInfo;

final class ConfigFileFinder
{
    /**
     * @var FinderSanitizer
     */
    private $finderSanitizer;

    /**
     * @var FileSystemFilter
     */
    private $fileSystemFilter;

    public function __construct(FinderSanitizer $finderSanitizer, FileSystemFilter $fileSystemFilter)
    {
        $this->finderSanitizer = $finderSanitizer;
        $this->fileSystemFilter = $fileSystemFilter;
    }

    /**
     * @return SmartFileInfo[]
     */
    public function findInSourceBySuffix(array $source, string $suffix): array
    {
        $files = $this->fileSystemFilter->filterFiles($source);

        $fileInfos = [];
        foreach ($files as $file) {
            $fileInfos[] = new SmartFileInfo($file);
        }

        $directories = $this->fileSystemFilter->filterDirectories($source);
        if (count($directories) === 0) {
            return $fileInfos;
        }

        $directoryFilesInfos = $this->findInDirectoriesBySuffix($directories, $suffix);
        return array_merge($fileInfos, $directoryFilesInfos);
    }

    /**
     * @return SmartFileInfo[]
     */
    private function findInDirectoriesBySuffix(array $directories, string $suffix): array
    {
        $finder = Finder::create()
            ->files()
            ->name('#\.' . $suffix . '#i')
            ->sortByName();

        foreach ($directories as $directory) {
            $finder->in($directory);
        }

        return $this->finderSanitizer->sanitize($finder);
    }
}
