<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Tests\Helper;

use Nette\Utils\FileSystem;
use Symfony\Component\Finder\SplFileInfo;

final class FixtureUpdater
{
    public static function updateFixtureContent(
        SplFileInfo|string $originalFileInfo,
        string $changedContent,
        SplFileInfo $fixtureFileInfo
    ): void {
        if (! getenv('UPDATE_TESTS') && ! getenv('UT')) {
            return;
        }

        $newOriginalContent = self::resolveNewFixtureContent($originalFileInfo, $changedContent);
        FileSystem::write($fixtureFileInfo->getRealPath(), $newOriginalContent);
    }

    public static function updateExpectedFixtureContent(
        string $newOriginalContent,
        SplFileInfo $expectedFixtureFileInfo
    ): void {
        if (! getenv('UPDATE_TESTS') && ! getenv('UT')) {
            return;
        }

        FileSystem::write($expectedFixtureFileInfo->getRealPath(), $newOriginalContent);
    }

    private static function resolveNewFixtureContent(
        SplFileInfo|string $originalFileInfo,
        string $changedContent
    ): string {
        if ($originalFileInfo instanceof SplFileInfo) {
            $originalContent = $originalFileInfo->getContents();
        } else {
            $originalContent = $originalFileInfo;
        }

        if ($originalContent === $changedContent) {
            return $originalContent;
        }

        return $originalContent . '-----' . PHP_EOL . $changedContent;
    }
}
