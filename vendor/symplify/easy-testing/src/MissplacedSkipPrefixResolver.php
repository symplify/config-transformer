<?php

declare (strict_types=1);
namespace ConfigTransformer2021082910\Symplify\EasyTesting;

use ConfigTransformer2021082910\Nette\Utils\Strings;
use ConfigTransformer2021082910\Symplify\EasyTesting\ValueObject\Prefix;
use ConfigTransformer2021082910\Symplify\EasyTesting\ValueObject\SplitLine;
use ConfigTransformer2021082910\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\EasyTesting\Tests\MissingSkipPrefixResolver\MissingSkipPrefixResolverTest
 */
final class MissplacedSkipPrefixResolver
{
    /**
     * @param SmartFileInfo[] $fixtureFileInfos
     * @return array<string, SmartFileInfo[]>
     */
    public function resolve(array $fixtureFileInfos) : array
    {
        $invalidFileInfos = ['incorrect_skips' => [], 'missing_skips' => []];
        foreach ($fixtureFileInfos as $fixtureFileInfo) {
            $hasNameSkipStart = $this->hasNameSkipStart($fixtureFileInfo);
            $fileContents = $fixtureFileInfo->getContents();
            $hasSplitLine = (bool) \ConfigTransformer2021082910\Nette\Utils\Strings::match($fileContents, \ConfigTransformer2021082910\Symplify\EasyTesting\ValueObject\SplitLine::SPLIT_LINE_REGEX);
            if ($hasNameSkipStart && $hasSplitLine) {
                $invalidFileInfos['incorrect_skips'][] = $fixtureFileInfo;
                continue;
            }
            if (!$hasNameSkipStart && !$hasSplitLine) {
                $invalidFileInfos['missing_skips'][] = $fixtureFileInfo;
                continue;
            }
        }
        return $invalidFileInfos;
    }
    private function hasNameSkipStart(\ConfigTransformer2021082910\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo) : bool
    {
        return (bool) \ConfigTransformer2021082910\Nette\Utils\Strings::match($fixtureFileInfo->getBasenameWithoutSuffix(), \ConfigTransformer2021082910\Symplify\EasyTesting\ValueObject\Prefix::SKIP_PREFIX_REGEX);
    }
}
