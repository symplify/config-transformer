<?php

declare (strict_types=1);
namespace ConfigTransformer2021082510\Symplify\EasyTesting\DataProvider;

use ConfigTransformer2021082510\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer2021082510\Symplify\SmartFileSystem\SmartFileSystem;
final class StaticFixtureUpdater
{
    public static function updateFixtureContent(\ConfigTransformer2021082510\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, string $changedContent, \ConfigTransformer2021082510\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo) : void
    {
        if (!\getenv('UPDATE_TESTS') && !\getenv('UT')) {
            return;
        }
        $newOriginalContent = self::resolveNewFixtureContent($originalFileInfo, $changedContent);
        self::getSmartFileSystem()->dumpFile($fixtureFileInfo->getRealPath(), $newOriginalContent);
    }
    public static function updateExpectedFixtureContent(string $newOriginalContent, \ConfigTransformer2021082510\Symplify\SmartFileSystem\SmartFileInfo $expectedFixtureFileInfo) : void
    {
        if (!\getenv('UPDATE_TESTS') && !\getenv('UT')) {
            return;
        }
        self::getSmartFileSystem()->dumpFile($expectedFixtureFileInfo->getRealPath(), $newOriginalContent);
    }
    private static function getSmartFileSystem() : \ConfigTransformer2021082510\Symplify\SmartFileSystem\SmartFileSystem
    {
        return new \ConfigTransformer2021082510\Symplify\SmartFileSystem\SmartFileSystem();
    }
    private static function resolveNewFixtureContent(\ConfigTransformer2021082510\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, string $changedContent) : string
    {
        if ($originalFileInfo->getContents() === $changedContent) {
            return $originalFileInfo->getContents();
        }
        return $originalFileInfo->getContents() . '-----' . \PHP_EOL . $changedContent;
    }
}
