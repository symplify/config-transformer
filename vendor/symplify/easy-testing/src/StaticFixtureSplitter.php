<?php

declare (strict_types=1);
namespace ConfigTransformer2021061210\Symplify\EasyTesting;

use ConfigTransformer2021061210\Nette\Utils\Strings;
use ConfigTransformer2021061210\Symplify\EasyTesting\ValueObject\InputAndExpected;
use ConfigTransformer2021061210\Symplify\EasyTesting\ValueObject\InputFileInfoAndExpected;
use ConfigTransformer2021061210\Symplify\EasyTesting\ValueObject\InputFileInfoAndExpectedFileInfo;
use ConfigTransformer2021061210\Symplify\EasyTesting\ValueObject\SplitLine;
use ConfigTransformer2021061210\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer2021061210\Symplify\SmartFileSystem\SmartFileSystem;
final class StaticFixtureSplitter
{
    /**
     * @var string|null
     */
    public static $customTemporaryPath;
    public static function splitFileInfoToInputAndExpected(\ConfigTransformer2021061210\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : \ConfigTransformer2021061210\Symplify\EasyTesting\ValueObject\InputAndExpected
    {
        $splitLineCount = \count(\ConfigTransformer2021061210\Nette\Utils\Strings::matchAll($smartFileInfo->getContents(), \ConfigTransformer2021061210\Symplify\EasyTesting\ValueObject\SplitLine::SPLIT_LINE_REGEX));
        // if more or less, it could be a test cases for monorepo line in it
        if ($splitLineCount === 1) {
            // input → expected
            [$input, $expected] = \ConfigTransformer2021061210\Nette\Utils\Strings::split($smartFileInfo->getContents(), \ConfigTransformer2021061210\Symplify\EasyTesting\ValueObject\SplitLine::SPLIT_LINE_REGEX);
            $expected = self::retypeExpected($expected);
            return new \ConfigTransformer2021061210\Symplify\EasyTesting\ValueObject\InputAndExpected($input, $expected);
        }
        // no changes
        return new \ConfigTransformer2021061210\Symplify\EasyTesting\ValueObject\InputAndExpected($smartFileInfo->getContents(), $smartFileInfo->getContents());
    }
    public static function splitFileInfoToLocalInputAndExpectedFileInfos(\ConfigTransformer2021061210\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, bool $autoloadTestFixture = \false) : \ConfigTransformer2021061210\Symplify\EasyTesting\ValueObject\InputFileInfoAndExpectedFileInfo
    {
        $inputAndExpected = self::splitFileInfoToInputAndExpected($smartFileInfo);
        $inputFileInfo = self::createTemporaryFileInfo($smartFileInfo, 'input', $inputAndExpected->getInput());
        // some files needs to be autoload to enable reflection
        if ($autoloadTestFixture) {
            require_once $inputFileInfo->getRealPath();
        }
        $expectedFileInfo = self::createTemporaryFileInfo($smartFileInfo, 'expected', $inputAndExpected->getExpected());
        return new \ConfigTransformer2021061210\Symplify\EasyTesting\ValueObject\InputFileInfoAndExpectedFileInfo($inputFileInfo, $expectedFileInfo);
    }
    public static function getTemporaryPath() : string
    {
        if (self::$customTemporaryPath !== null) {
            return self::$customTemporaryPath;
        }
        return \sys_get_temp_dir() . '/_temp_fixture_easy_testing';
    }
    public static function createTemporaryFileInfo(\ConfigTransformer2021061210\Symplify\SmartFileSystem\SmartFileInfo $fixtureSmartFileInfo, string $prefix, string $fileContent) : \ConfigTransformer2021061210\Symplify\SmartFileSystem\SmartFileInfo
    {
        $temporaryFilePath = self::createTemporaryPathWithPrefix($fixtureSmartFileInfo, $prefix);
        $smartFileSystem = new \ConfigTransformer2021061210\Symplify\SmartFileSystem\SmartFileSystem();
        $smartFileSystem->dumpFile($temporaryFilePath, $fileContent);
        return new \ConfigTransformer2021061210\Symplify\SmartFileSystem\SmartFileInfo($temporaryFilePath);
    }
    public static function splitFileInfoToLocalInputAndExpected(\ConfigTransformer2021061210\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, bool $autoloadTestFixture = \false) : \ConfigTransformer2021061210\Symplify\EasyTesting\ValueObject\InputFileInfoAndExpected
    {
        $inputAndExpected = self::splitFileInfoToInputAndExpected($smartFileInfo);
        $inputFileInfo = self::createTemporaryFileInfo($smartFileInfo, 'input', $inputAndExpected->getInput());
        // some files needs to be autoload to enable reflection
        if ($autoloadTestFixture) {
            require_once $inputFileInfo->getRealPath();
        }
        return new \ConfigTransformer2021061210\Symplify\EasyTesting\ValueObject\InputFileInfoAndExpected($inputFileInfo, $inputAndExpected->getExpected());
    }
    private static function createTemporaryPathWithPrefix(\ConfigTransformer2021061210\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, string $prefix) : string
    {
        $hash = \ConfigTransformer2021061210\Nette\Utils\Strings::substring(\md5($smartFileInfo->getRealPath()), -20);
        $fileBaseName = $smartFileInfo->getBasename('.inc');
        return self::getTemporaryPath() . \sprintf('/%s_%s_%s', $prefix, $hash, $fileBaseName);
    }
    /**
     * @return mixed|int|float
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
