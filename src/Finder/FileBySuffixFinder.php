<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\Finder;

use Symfony\Component\Finder\Finder;
use Symplify\SmartFileSystem\FileSystemFilter;
use Symplify\SmartFileSystem\Finder\FinderSanitizer;
use Symplify\SmartFileSystem\SmartFileInfo;

final class FileBySuffixFinder
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
    public function findInSourceBySuffixes(array $source, array $suffixes): array
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

        $finder = Finder::create()
            ->files()
            ->in($directories)
            ->sortByName();

        $directoryFileInfos = $this->finderSanitizer->sanitize($finder);

        $fileInfos = array_merge($fileInfos, $directoryFileInfos);

        return array_filter($fileInfos, function (SmartFileInfo $smartFileInfo) use ($suffixes) {
            return in_array($smartFileInfo->getSuffix(), $suffixes, true);
        });
    }
}
