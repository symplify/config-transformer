<?php

declare (strict_types=1);
namespace ConfigTransformer2022051110\Symplify\EasyTesting\FixtureSplitter;

use ConfigTransformer2022051110\Nette\Utils\Strings;
use ConfigTransformer2022051110\Symplify\EasyTesting\ValueObject\FixtureSplit\TrioContent;
use ConfigTransformer2022051110\Symplify\EasyTesting\ValueObject\SplitLine;
use ConfigTransformer2022051110\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer2022051110\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
/**
 * @api
 */
final class TrioFixtureSplitter
{
    public function splitFileInfo(\ConfigTransformer2022051110\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \ConfigTransformer2022051110\Symplify\EasyTesting\ValueObject\FixtureSplit\TrioContent
    {
        $parts = \ConfigTransformer2022051110\Nette\Utils\Strings::split($smartFileInfo->getContents(), \ConfigTransformer2022051110\Symplify\EasyTesting\ValueObject\SplitLine::SPLIT_LINE_REGEX);
        $this->ensureHasThreeParts($parts, $smartFileInfo);
        return new \ConfigTransformer2022051110\Symplify\EasyTesting\ValueObject\FixtureSplit\TrioContent($parts[0], $parts[1], $parts[2]);
    }
    /**
     * @param mixed[] $parts
     */
    private function ensureHasThreeParts(array $parts, \ConfigTransformer2022051110\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        if (\count($parts) === 3) {
            return;
        }
        $message = \sprintf('The fixture "%s" should have 3 parts. %d found', $smartFileInfo->getRelativeFilePathFromCwd(), \count($parts));
        throw new \ConfigTransformer2022051110\Symplify\SymplifyKernel\Exception\ShouldNotHappenException($message);
    }
}
