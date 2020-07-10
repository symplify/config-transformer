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

        $suffixRegex = '#\.(' . implode('|', $suffixes) . ')$#i';
        $finder = Finder::create()
            ->files()
            ->in($directories)
            ->name($suffixRegex)
            ->sortByName();

        $directoryFileInfos = $this->finderSanitizer->sanitize($finder);

        return array_merge($fileInfos, $directoryFileInfos);
    }
}
