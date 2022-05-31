<?php

declare (strict_types=1);
namespace ConfigTransformer202205317\Symplify\SmartFileSystem\Finder;

use ConfigTransformer202205317\Nette\Utils\Finder as NetteFinder;
use SplFileInfo;
use ConfigTransformer202205317\Symfony\Component\Finder\Finder as SymfonyFinder;
use ConfigTransformer202205317\Symfony\Component\Finder\SplFileInfo as SymfonySplFileInfo;
use ConfigTransformer202205317\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\SmartFileSystem\Tests\Finder\FinderSanitizer\FinderSanitizerTest
 */
final class FinderSanitizer
{
    /**
     * @param NetteFinder|SymfonyFinder|mixed[] $files
     * @return SmartFileInfo[]
     */
    public function sanitize($files) : array
    {
        $smartFileInfos = [];
        foreach ($files as $file) {
            $fileInfo = \is_string($file) ? new \SplFileInfo($file) : $file;
            if (!$this->isFileInfoValid($fileInfo)) {
                continue;
            }
            /** @var string $realPath */
            $realPath = $fileInfo->getRealPath();
            $smartFileInfos[] = new \ConfigTransformer202205317\Symplify\SmartFileSystem\SmartFileInfo($realPath);
        }
        return $smartFileInfos;
    }
    private function isFileInfoValid(\SplFileInfo $fileInfo) : bool
    {
        return (bool) $fileInfo->getRealPath();
    }
}
