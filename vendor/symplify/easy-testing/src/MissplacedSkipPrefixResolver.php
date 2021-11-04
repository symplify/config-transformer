<?php

declare (strict_types=1);
namespace ConfigTransformer202111047\Symplify\EasyTesting;

use ConfigTransformer202111047\Nette\Utils\Strings;
use ConfigTransformer202111047\Symplify\EasyTesting\ValueObject\Prefix;
use ConfigTransformer202111047\Symplify\EasyTesting\ValueObject\SplitLine;
use ConfigTransformer202111047\Symplify\SmartFileSystem\SmartFileInfo;
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
            $hasSplitLine = (bool) \ConfigTransformer202111047\Nette\Utils\Strings::match($fileContents, \ConfigTransformer202111047\Symplify\EasyTesting\ValueObject\SplitLine::SPLIT_LINE_REGEX);
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
    private function hasNameSkipStart(\ConfigTransformer202111047\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo) : bool
    {
        return (bool) \ConfigTransformer202111047\Nette\Utils\Strings::match($fixtureFileInfo->getBasenameWithoutSuffix(), \ConfigTransformer202111047\Symplify\EasyTesting\ValueObject\Prefix::SKIP_PREFIX_REGEX);
    }
}
