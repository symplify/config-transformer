<?php

declare (strict_types=1);
namespace ConfigTransformer202111031\Symplify\SmartFileSystem\Finder;

use ConfigTransformer202111031\Nette\Utils\Finder as NetteFinder;
use SplFileInfo;
use ConfigTransformer202111031\Symfony\Component\Finder\Finder as SymfonyFinder;
use ConfigTransformer202111031\Symfony\Component\Finder\SplFileInfo as SymfonySplFileInfo;
use ConfigTransformer202111031\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\SmartFileSystem\Tests\Finder\FinderSanitizer\FinderSanitizerTest
 */
final class FinderSanitizer
{
    /**
     * @param mixed[]|\Nette\Utils\Finder|\Symfony\Component\Finder\Finder $files
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
            $smartFileInfos[] = new \ConfigTransformer202111031\Symplify\SmartFileSystem\SmartFileInfo($realPath);
        }
        return $smartFileInfos;
    }
    private function isFileInfoValid(\SplFileInfo $fileInfo) : bool
    {
        return (bool) $fileInfo->getRealPath();
    }
}
