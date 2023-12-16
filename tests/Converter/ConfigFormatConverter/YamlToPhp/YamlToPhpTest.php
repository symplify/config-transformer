<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Tests\Converter\ConfigFormatConverter\YamlToPhp;

use Iterator;
use Nette\Utils\FileSystem;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\Finder\SplFileInfo;
use Symplify\ConfigTransformer\Converter\ConfigFormatConverter;
use Symplify\ConfigTransformer\FileSystem\RelativeFilePathHelper;
use Symplify\ConfigTransformer\Tests\AbstractTestCase;
use Symplify\ConfigTransformer\Tests\Helper\FixtureFinder;
use Symplify\ConfigTransformer\Tests\Helper\FixtureSplitter;
use Symplify\ConfigTransformer\Tests\Helper\FixtureUpdater;

final class YamlToPhpTest extends AbstractTestCase
{
    private ConfigFormatConverter $configFormatConverter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->configFormatConverter = $this->getService(ConfigFormatConverter::class);
    }

    #[DataProvider('provideDataForRouting')]
    public function testRouting(SplFileInfo $fileInfo): void
    {
        $this->doTestOutput($fileInfo, true);
    }

    public static function provideDataForRouting(): Iterator
    {
        return FixtureFinder::yieldDirectory(__DIR__ . '/Fixture/routing', '*.yaml');
    }

    #[DataProvider('provideData')]
    #[DataProvider('provideDataWithPhpImported')]
    public function testNormal(SplFileInfo $fixtureFileInfo): void
    {
        // for imports
        $temporaryPath = FixtureSplitter::getTemporaryPath();

        $filesystem = new \Symfony\Component\Filesystem\Filesystem();
        $filesystem->mirror(__DIR__ . '/Fixture/normal', $temporaryPath);

        // for the "resource: items/"
        FileSystem::createDir($temporaryPath . '/items');

        // for the "resource: packages/" and assetic import
        FileSystem::copy(__DIR__ . '/Fixture/normal/import_assetic/packages', $temporaryPath . '/packages');

        // for the "resource: directory-with-php/" and PHP config import
        FileSystem::copy(
            __DIR__ . '/Fixture/skip-imported-php/directory-with-php',
            $temporaryPath . '/directory-with-php'
        );

        FileSystem::copy(
            __DIR__ . '/Fixture/normal/directory-with-unquoted-strings',
            $temporaryPath . '/directory-with-unquoted-strings'
        );

        $this->doTestOutput($fixtureFileInfo);
    }

    public static function provideData(): Iterator
    {
        return FixtureFinder::yieldDirectory(__DIR__ . '/Fixture/normal', '*.yaml');
    }

    public static function provideDataWithPhpImported(): Iterator
    {
        return FixtureFinder::yieldDirectory(__DIR__ . '/Fixture/skip-imported-php', '*.yaml');
    }

    private function doTestOutput(SplFileInfo $fixtureFileInfo, bool $preserveDirStructure = false): void
    {
        $inputAndExpected = FixtureSplitter::splitFileInfoToLocalInputAndExpectedFileInfos($fixtureFileInfo, false, $preserveDirStructure);

        $inputFileInfo = $inputAndExpected->getInputFileInfo();
        $convertedContent = $this->configFormatConverter->convert($inputFileInfo);

        // run `UT=1 vendor/bin/phpunit` to update test fixtures content
        FixtureUpdater::updateFixtureContent($inputFileInfo, $convertedContent, $fixtureFileInfo);

        $filePath = RelativeFilePathHelper::resolveFromDirectory($fixtureFileInfo->getRealPath(), getcwd());
        $this->assertSame($inputAndExpected->getExpectedFileContent(), $convertedContent, $filePath);
    }
}
