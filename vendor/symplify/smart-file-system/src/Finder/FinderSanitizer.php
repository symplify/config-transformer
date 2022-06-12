<?php

declare (strict_types=1);
namespace ConfigTransformer20220612\Symplify\SmartFileSystem\Finder;

use ConfigTransformer20220612\Nette\Utils\Finder as NetteFinder;
use SplFileInfo;
use ConfigTransformer20220612\Symfony\Component\Finder\Finder as SymfonyFinder;
use ConfigTransformer20220612\Symfony\Component\Finder\SplFileInfo as SymfonySplFileInfo;
use ConfigTransformer20220612\Symplify\SmartFileSystem\SmartFileInfo;
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
            $fileInfo = \is_string($file) ? new SplFileInfo($file) : $file;
            if (!$this->isFileInfoValid($fileInfo)) {
                continue;
            }
            /** @var string $realPath */
            $realPath = $fileInfo->getRealPath();
            $smartFileInfos[] = new SmartFileInfo($realPath);
        }
        return $smartFileInfos;
    }
    private function isFileInfoValid(SplFileInfo $fileInfo) : bool
    {
        return (bool) $fileInfo->getRealPath();
    }
}
