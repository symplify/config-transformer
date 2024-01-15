<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Tests\Helper;

use Nette\Utils\FileSystem;
use Nette\Utils\Strings;
use Symfony\Component\Finder\SplFileInfo;
use Symplify\ConfigTransformer\Tests\Helper\ValueObject\InputAndExpected;
use Symplify\ConfigTransformer\Tests\Helper\ValueObject\InputFileInfoAndExpectedFileInfo;

final class FixtureSplitter
{
    /**
     * @see https://regex101.com/r/8fuULy/1
     * @var string
     */
    private const SPLIT_LINE_REGEX = "#\-\-\-\-\-\r?\n#";

    public static ?string $customTemporaryPath = null;

    public static function splitFileInfoToInputAndExpected(SplFileInfo $smartFileInfo): InputAndExpected
    {
        $splitLineCount = count(Strings::matchAll($smartFileInfo->getContents(), self::SPLIT_LINE_REGEX));

        // if more or less, it could be a test cases for monorepo line in it
        if ($splitLineCount === 1) {
            // input → expected
            [$input, $expected] = Strings::split($smartFileInfo->getContents(), self::SPLIT_LINE_REGEX);

            $expected = self::retypeExpected($expected);

            return new InputAndExpected($input, $expected);
        }

        // no changes
        return new InputAndExpected($smartFileInfo->getContents(), $smartFileInfo->getContents());
    }

    public static function splitFileInfoToLocalInputAndExpectedFileInfos(
        SplFileInfo $fileInfo,
        bool $autoloadTestFixture = false,
        bool $preserveDirStructure = false
    ): InputFileInfoAndExpectedFileInfo {
        $inputAndExpected = self::splitFileInfoToInputAndExpected($fileInfo);

        $prefix = '';
        if ($preserveDirStructure) {
            $dir = explode('Fixture', $fileInfo->getRealPath(), 2);
            $prefix = isset($dir[1]) ? dirname($dir[1]) . '/' : '';
            $prefix = ltrim($prefix, '/\\');
        }

        $inputFileInfo = self::createTemporaryFileInfo(
            $fileInfo,
            $prefix . 'input',
            $inputAndExpected->getInput()
        );

        // some files needs to be autoload to enable reflection
        if ($autoloadTestFixture) {
            require_once $inputFileInfo->getRealPath();
        }

        $expectedFileInfo = self::createTemporaryFileInfo(
            $fileInfo,
            $prefix . 'expected',
            $inputAndExpected->getExpected()
        );

        return new InputFileInfoAndExpectedFileInfo($inputFileInfo, $expectedFileInfo);
    }

    public static function getTemporaryPath(): string
    {
        if (self::$customTemporaryPath !== null) {
            return self::$customTemporaryPath;
        }

        return sys_get_temp_dir() . '/_temp_fixture_easy_testing';
    }

    private static function createTemporaryFileInfo(
        SplFileInfo $fixtureSmartFileInfo,
        string $prefix,
        string $fileContent
    ): SplFileInfo {
        $temporaryFilePath = self::createTemporaryPathWithPrefix($fixtureSmartFileInfo, $prefix);
        $dir = dirname($temporaryFilePath);
        if (! is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        FileSystem::write($temporaryFilePath, $fileContent);
        return new SplFileInfo($temporaryFilePath, '', '');
    }

    private static function createTemporaryPathWithPrefix(SplFileInfo $fileInfo, string $prefix): string
    {
        $hash = Strings::substring(md5($fileInfo->getRealPath()), -20);

        $fileBasename = $fileInfo->getBasename('.inc');

        return self::getTemporaryPath() . sprintf('/%s_%s_%s', $prefix, $hash, $fileBasename);
    }

    private static function retypeExpected(mixed $expected): mixed
    {
        if (! is_numeric(trim((string) $expected))) {
            return $expected;
        }

        // value re-type
        if (strlen((string) (int) $expected) === strlen(trim((string) $expected))) {
            return (int) $expected;
        }

        if (strlen((string) (float) $expected) === strlen(trim((string) $expected))) {
            return (float) $expected;
        }

        return $expected;
    }
}
