<?php

declare (strict_types=1);
namespace ConfigTransformer202112087\Symplify\EasyTesting;

use ConfigTransformer202112087\Nette\Utils\Strings;
use ConfigTransformer202112087\Symplify\EasyTesting\ValueObject\InputAndExpected;
use ConfigTransformer202112087\Symplify\EasyTesting\ValueObject\InputFileInfoAndExpected;
use ConfigTransformer202112087\Symplify\EasyTesting\ValueObject\InputFileInfoAndExpectedFileInfo;
use ConfigTransformer202112087\Symplify\EasyTesting\ValueObject\SplitLine;
use ConfigTransformer202112087\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer202112087\Symplify\SmartFileSystem\SmartFileSystem;
/**
 * @api
 */
final class StaticFixtureSplitter
{
    /**
     * @var string|null
     */
    public static $customTemporaryPath;
    public static function splitFileInfoToInputAndExpected(\ConfigTransformer202112087\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \ConfigTransformer202112087\Symplify\EasyTesting\ValueObject\InputAndExpected
    {
        $splitLineCount = \count(\ConfigTransformer202112087\Nette\Utils\Strings::matchAll($smartFileInfo->getContents(), \ConfigTransformer202112087\Symplify\EasyTesting\ValueObject\SplitLine::SPLIT_LINE_REGEX));
        // if more or less, it could be a test cases for monorepo line in it
        if ($splitLineCount === 1) {
            // input → expected
            [$input, $expected] = \ConfigTransformer202112087\Nette\Utils\Strings::split($smartFileInfo->getContents(), \ConfigTransformer202112087\Symplify\EasyTesting\ValueObject\SplitLine::SPLIT_LINE_REGEX);
            $expected = self::retypeExpected($expected);
            return new \ConfigTransformer202112087\Symplify\EasyTesting\ValueObject\InputAndExpected($input, $expected);
        }
        // no changes
        return new \ConfigTransformer202112087\Symplify\EasyTesting\ValueObject\InputAndExpected($smartFileInfo->getContents(), $smartFileInfo->getContents());
    }
    public static function splitFileInfoToLocalInputAndExpectedFileInfos(\ConfigTransformer202112087\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, bool $autoloadTestFixture = \false) : \ConfigTransformer202112087\Symplify\EasyTesting\ValueObject\InputFileInfoAndExpectedFileInfo
    {
        $inputAndExpected = self::splitFileInfoToInputAndExpected($smartFileInfo);
        $inputFileInfo = self::createTemporaryFileInfo($smartFileInfo, 'input', $inputAndExpected->getInput());
        // some files needs to be autoload to enable reflection
        if ($autoloadTestFixture) {
            require_once $inputFileInfo->getRealPath();
        }
        $expectedFileInfo = self::createTemporaryFileInfo($smartFileInfo, 'expected', $inputAndExpected->getExpected());
        return new \ConfigTransformer202112087\Symplify\EasyTesting\ValueObject\InputFileInfoAndExpectedFileInfo($inputFileInfo, $expectedFileInfo);
    }
    public static function getTemporaryPath() : string
    {
        if (self::$customTemporaryPath !== null) {
            return self::$customTemporaryPath;
        }
        return \sys_get_temp_dir() . '/_temp_fixture_easy_testing';
    }
    public static function createTemporaryFileInfo(\ConfigTransformer202112087\Symplify\SmartFileSystem\SmartFileInfo $fixtureSmartFileInfo, string $prefix, string $fileContent) : \ConfigTransformer202112087\Symplify\SmartFileSystem\SmartFileInfo
    {
        $temporaryFilePath = self::createTemporaryPathWithPrefix($fixtureSmartFileInfo, $prefix);
        $dir = \dirname($temporaryFilePath);
        if (!\is_dir($dir)) {
            \mkdir($dir, 0777, \true);
        }
        /** @phpstan-ignore-next-line we don't use SmartFileSystem->dump() for performance reasons */
        \file_put_contents($temporaryFilePath, $fileContent);
        return new \ConfigTransformer202112087\Symplify\SmartFileSystem\SmartFileInfo($temporaryFilePath);
    }
    public static function splitFileInfoToLocalInputAndExpected(\ConfigTransformer202112087\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, bool $autoloadTestFixture = \false) : \ConfigTransformer202112087\Symplify\EasyTesting\ValueObject\InputFileInfoAndExpected
    {
        $inputAndExpected = self::splitFileInfoToInputAndExpected($smartFileInfo);
        $inputFileInfo = self::createTemporaryFileInfo($smartFileInfo, 'input', $inputAndExpected->getInput());
        // some files needs to be autoload to enable reflection
        if ($autoloadTestFixture) {
            require_once $inputFileInfo->getRealPath();
        }
        return new \ConfigTransformer202112087\Symplify\EasyTesting\ValueObject\InputFileInfoAndExpected($inputFileInfo, $inputAndExpected->getExpected());
    }
    private static function createTemporaryPathWithPrefix(\ConfigTransformer202112087\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, string $prefix) : string
    {
        $hash = \ConfigTransformer202112087\Nette\Utils\Strings::substring(\md5($smartFileInfo->getRealPath()), -20);
        $fileBaseName = $smartFileInfo->getBasename('.inc');
        return self::getTemporaryPath() . \sprintf('/%s_%s_%s', $prefix, $hash, $fileBaseName);
    }
    /**
     * @return mixed
     * @param mixed $expected
     */
    private static function retypeExpected($expected)
    {
        if (!\is_numeric(\trim($expected))) {
            return $expected;
        }
        // value re-type
        if (\strlen((string) (int) $expected) === \strlen(\trim($expected))) {
            return (int) $expected;
        }
        if (\strlen((string) (float) $expected) === \strlen(\trim($expected))) {
            return (float) $expected;
        }
        return $expected;
    }
}
