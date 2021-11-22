<?php

declare (strict_types=1);
namespace ConfigTransformer2021112210\Symplify\EasyTesting\FixtureSplitter;

use ConfigTransformer2021112210\Nette\Utils\Strings;
use ConfigTransformer2021112210\Symplify\EasyTesting\ValueObject\FixtureSplit\TrioContent;
use ConfigTransformer2021112210\Symplify\EasyTesting\ValueObject\SplitLine;
use ConfigTransformer2021112210\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer2021112210\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
/**
 * @api
 */
final class TrioFixtureSplitter
{
    public function splitFileInfo(\ConfigTransformer2021112210\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \ConfigTransformer2021112210\Symplify\EasyTesting\ValueObject\FixtureSplit\TrioContent
    {
        $parts = \ConfigTransformer2021112210\Nette\Utils\Strings::split($smartFileInfo->getContents(), \ConfigTransformer2021112210\Symplify\EasyTesting\ValueObject\SplitLine::SPLIT_LINE_REGEX);
        $this->ensureHasThreeParts($parts, $smartFileInfo);
        return new \ConfigTransformer2021112210\Symplify\EasyTesting\ValueObject\FixtureSplit\TrioContent($parts[0], $parts[1], $parts[2]);
    }
    /**
     * @param mixed[] $parts
     */
    private function ensureHasThreeParts(array $parts, \ConfigTransformer2021112210\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        if (\count($parts) === 3) {
            return;
        }
        $message = \sprintf('The fixture "%s" should have 3 parts. %d found', $smartFileInfo->getRelativeFilePathFromCwd(), \count($parts));
        throw new \ConfigTransformer2021112210\Symplify\SymplifyKernel\Exception\ShouldNotHappenException($message);
    }
}
