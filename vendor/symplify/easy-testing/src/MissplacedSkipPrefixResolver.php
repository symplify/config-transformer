<?php

declare (strict_types=1);
namespace ConfigTransformer2022031610\Symplify\EasyTesting;

use ConfigTransformer2022031610\Nette\Utils\Strings;
use ConfigTransformer2022031610\Symplify\EasyTesting\ValueObject\IncorrectAndMissingSkips;
use ConfigTransformer2022031610\Symplify\EasyTesting\ValueObject\Prefix;
use ConfigTransformer2022031610\Symplify\EasyTesting\ValueObject\SplitLine;
use ConfigTransformer2022031610\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\EasyTesting\Tests\MissingSkipPrefixResolver\MissingSkipPrefixResolverTest
 */
final class MissplacedSkipPrefixResolver
{
    /**
     * @param SmartFileInfo[] $fixtureFileInfos
     */
    public function resolve(array $fixtureFileInfos) : \ConfigTransformer2022031610\Symplify\EasyTesting\ValueObject\IncorrectAndMissingSkips
    {
        $incorrectSkips = [];
        $missingSkips = [];
        foreach ($fixtureFileInfos as $fixtureFileInfo) {
            $hasNameSkipStart = $this->hasNameSkipStart($fixtureFileInfo);
            $fileContents = $fixtureFileInfo->getContents();
            $hasSplitLine = (bool) \ConfigTransformer2022031610\Nette\Utils\Strings::match($fileContents, \ConfigTransformer2022031610\Symplify\EasyTesting\ValueObject\SplitLine::SPLIT_LINE_REGEX);
            if ($hasNameSkipStart && $hasSplitLine) {
                $incorrectSkips[] = $fixtureFileInfo;
                continue;
            }
            if (!$hasNameSkipStart && !$hasSplitLine) {
                $missingSkips[] = $fixtureFileInfo;
            }
        }
        return new \ConfigTransformer2022031610\Symplify\EasyTesting\ValueObject\IncorrectAndMissingSkips($incorrectSkips, $missingSkips);
    }
    private function hasNameSkipStart(\ConfigTransformer2022031610\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo) : bool
    {
        return (bool) \ConfigTransformer2022031610\Nette\Utils\Strings::match($fixtureFileInfo->getBasenameWithoutSuffix(), \ConfigTransformer2022031610\Symplify\EasyTesting\ValueObject\Prefix::SKIP_PREFIX_REGEX);
    }
}
