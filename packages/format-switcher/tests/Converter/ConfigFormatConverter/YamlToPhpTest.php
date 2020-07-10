<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Tests\Converter\ConfigFormatConverter;

use Iterator;
use Nette\Utils\FileSystem;
use Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use Symplify\EasyTesting\StaticFixtureSplitter;
use Symplify\SmartFileSystem\SmartFileInfo;

final class YamlToPhpTest extends AbstractConfigFormatConverterTest
{
    /**
     * @dataProvider provideData()
     */
    public function test(SmartFileInfo $fixtureFileInfo): void
    {
        $this->doTestOutput($fixtureFileInfo, 'yaml', 'php');
    }

    /**
     * @dataProvider provideDataWithDirectory()
     */
    public function testSpecialCaseWithDirectory(SmartFileInfo $fileInfo): void
    {
        $this->doTestOutputWithExtraDirectory($fileInfo, __DIR__ . '/FixtureYamlToPhp/nested', 'yaml', 'php');
    }

    /**
     * @source https://github.com/symfony/maker-bundle/pull/604
     * @dataProvider provideDataMakerBundle()
     */
    public function testMakerBundle(SmartFileInfo $fileInfo): void
    {
        // needed for all the included
        $temporaryPath = StaticFixtureSplitter::getTemporaryPath();
        FileSystem::write($temporaryPath . '/../src/SomeClass.php', '<?php namespace App { class SomeClass {} }');
        require_once $temporaryPath . '/../src/SomeClass.php';
        FileSystem::createDir($temporaryPath . '/../src/Controller');
        FileSystem::createDir($temporaryPath . '/../src/Domain');

        $this->doTestOutput($fileInfo, 'yaml', 'php');
    }

    public function provideData(): Iterator
    {
        return StaticFixtureFinder::yieldDirectory(__DIR__ . '/FixtureYamlToPhp/normal', '*.yaml');
    }

    public function provideDataWithDirectory(): Iterator
    {
        return StaticFixtureFinder::yieldDirectory(__DIR__ . '/FixtureYamlToPhp/nested', '*.yaml');
    }

    public function provideDataMakerBundle(): Iterator
    {
        return StaticFixtureFinder::yieldDirectory(__DIR__ . '/FixtureYamlToPhp/maker-bundle', '*.yaml');
    }

    private function doTestOutputWithExtraDirectory(
        SmartFileInfo $fixtureFileInfo,
        $extraDirectory,
        string $inputFormat,
        string $outputFormat
    ): void {
        [$inputContent, $expectedContent] = StaticFixtureSplitter::splitFileInfoToInputAndExpected(
            $fixtureFileInfo
        );

        $temporaryPath = StaticFixtureSplitter::getTemporaryPath();

        // copy /src to temp directory, so Symfony FileLocator knows about it
        FileSystem::copy($extraDirectory, $temporaryPath, true);

        $fileTemporaryPath = $temporaryPath . '/' . $fixtureFileInfo->getRelativeFilePathFromDirectory($extraDirectory);
        FileSystem::write($fileTemporaryPath, $inputContent);

        // rquire class, so its autoloaded
        assert(file_exists($temporaryPath . '/src/SomeClass.php'));
        require_once $temporaryPath . '/src/SomeClass.php';

        $inputFileInfo = new SmartFileInfo($fileTemporaryPath);
        $this->doTestFileInfo($inputFileInfo, $expectedContent, $fixtureFileInfo, $inputFormat, $outputFormat);
    }
}
