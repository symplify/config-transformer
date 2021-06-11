<?php

declare (strict_types=1);
namespace ConfigTransformer202106110\Symplify\EasyTesting\FixtureSplitter;

use ConfigTransformer202106110\Nette\Utils\Strings;
use ConfigTransformer202106110\Symplify\EasyTesting\ValueObject\FixtureSplit\TrioContent;
use ConfigTransformer202106110\Symplify\EasyTesting\ValueObject\SplitLine;
use ConfigTransformer202106110\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer202106110\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class TrioFixtureSplitter
{
    public function splitFileInfo(\ConfigTransformer202106110\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \ConfigTransformer202106110\Symplify\EasyTesting\ValueObject\FixtureSplit\TrioContent
    {
        $parts = \ConfigTransformer202106110\Nette\Utils\Strings::split($smartFileInfo->getContents(), \ConfigTransformer202106110\Symplify\EasyTesting\ValueObject\SplitLine::SPLIT_LINE_REGEX);
        $this->ensureHasThreeParts($parts, $smartFileInfo);
        return new \ConfigTransformer202106110\Symplify\EasyTesting\ValueObject\FixtureSplit\TrioContent($parts[0], $parts[1], $parts[2]);
    }
    /**
     * @param mixed[] $parts
     */
    private function ensureHasThreeParts(array $parts, \ConfigTransformer202106110\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        if (\count($parts) === 3) {
            return;
        }
        $message = \sprintf('The fixture "%s" should have 3 parts. %d found', $smartFileInfo->getRelativeFilePathFromCwd(), \count($parts));
        throw new \ConfigTransformer202106110\Symplify\SymplifyKernel\Exception\ShouldNotHappenException($message);
    }
}