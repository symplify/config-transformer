<?php

declare (strict_types=1);
namespace ConfigTransformer202106110\Symplify\SmartFileSystem\Finder;

use ConfigTransformer202106110\Nette\Utils\Finder as NetteFinder;
use SplFileInfo;
use ConfigTransformer202106110\Symfony\Component\Finder\Finder as SymfonyFinder;
use ConfigTransformer202106110\Symfony\Component\Finder\SplFileInfo as SymfonySplFileInfo;
use ConfigTransformer202106110\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\SmartFileSystem\Tests\Finder\FinderSanitizer\FinderSanitizerTest
 */
final class FinderSanitizer
{
    /**
     * @param NetteFinder|SymfonyFinder|SplFileInfo[]|SymfonySplFileInfo[]|string[] $files
     * @return SmartFileInfo[]
     */
    public function sanitize(iterable $files) : array
    {
        $smartFileInfos = [];
        foreach ($files as $file) {
            $fileInfo = \is_string($file) ? new \SplFileInfo($file) : $file;
            if (!$this->isFileInfoValid($fileInfo)) {
                continue;
            }
            /** @var string $realPath */
            $realPath = $fileInfo->getRealPath();
            $smartFileInfos[] = new \ConfigTransformer202106110\Symplify\SmartFileSystem\SmartFileInfo($realPath);
        }
        return $smartFileInfos;
    }
    private function isFileInfoValid(\SplFileInfo $fileInfo) : bool
    {
        return (bool) $fileInfo->getRealPath();
    }
}