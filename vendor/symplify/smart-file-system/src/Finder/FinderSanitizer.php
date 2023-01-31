<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202301\Symplify\SmartFileSystem\Finder;

use ConfigTransformerPrefix202301\Symfony\Component\Finder\Finder;
use ConfigTransformerPrefix202301\Symfony\Component\Finder\SplFileInfo;
use ConfigTransformerPrefix202301\Symplify\SmartFileSystem\SmartFileInfo;
final class FinderSanitizer
{
    /**
     * @return SmartFileInfo[]
     */
    public function sanitize(Finder $finder) : array
    {
        $smartFileInfos = [];
        foreach ($finder as $fileInfo) {
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
