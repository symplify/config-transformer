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

    /**
     * @return Iterator<mixed, \SplFileInfo[]>
     */
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

    #[DataProvider('provideDataWithDirectory')]
    public function testSpecialCaseWithDirectory(SplFileInfo $fileInfo): void
    {
        $this->doTestOutputWithExtraDirectory($fileInfo, __DIR__ . '/Fixture/nested');
    }

    #[DataProvider('provideDataExtension')]
    public function testEcs(SplFileInfo $fileInfo): void
    {
        $this->doTestOutputWithExtraDirectory($fileInfo, $fileInfo->getPath());
    }

    /**
     * @source https://github.com/symfony/maker-bundle/pull/604
     */
    #[DataProvider('provideDataMakerBundle')]
    public function testMakerBundle(SplFileInfo $fileInfo): void
    {
        // needed for all the included
        $temporaryPath = FixtureSplitter::getTemporaryPath();
        FileSystem::write(
            $temporaryPath . '/../src/SomeClass.php',
            '<?php namespace App { class SomeClass {} }'
        );
        require_once $temporaryPath . '/../src/SomeClass.php';

        FileSystem::createDir($temporaryPath . '/../src/Controller');
        FileSystem::createDir($temporaryPath . '/../src/Domain');

        $this->doTestOutput($fileInfo);
    }

    /**
     * @return Iterator<mixed, \SplFileInfo[]>
     */
    public static function provideData(): Iterator
    {
        return FixtureFinder::yieldDirectory(__DIR__ . '/Fixture/normal', '*.yaml');
    }

    /**
     * @return Iterator<mixed, \SplFileInfo[]>
     */
    public static function provideDataWithPhpImported(): Iterator
    {
        return FixtureFinder::yieldDirectory(__DIR__ . '/Fixture/skip-imported-php', '*.yaml');
    }

    /**
     * @return Iterator<mixed, \SplFileInfo[]>
     */
    public static function provideDataExtension(): Iterator
    {
        return FixtureFinder::yieldDirectory(__DIR__ . '/Fixture/extension', '*.yaml');
    }

    /**
     * @return Iterator<mixed, \SplFileInfo[]>
     */
    public static function provideDataWithDirectory(): Iterator
    {
        return FixtureFinder::yieldDirectory(__DIR__ . '/Fixture/nested', '*.yaml');
    }

    /**
     * @return Iterator<mixed, SplFileInfo[]>
     */
    public static function provideDataMakerBundle(): Iterator
    {
        return FixtureFinder::yieldDirectory(__DIR__ . '/Fixture/maker-bundle', '*.yaml');
    }

    private function doTestOutput(SplFileInfo $fixtureFileInfo, bool $preserveDirStructure = false): void
    {
        $inputAndExpected = FixtureSplitter::splitFileInfoToLocalInputAndExpectedFileInfos($fixtureFileInfo, false, $preserveDirStructure);

        $this->doTestFileInfo($inputAndExpected->getInputFileInfo(), $inputAndExpected->getExpectedFileContent(), $fixtureFileInfo);
    }

    private function doTestFileInfo(SplFileInfo $inputFileInfo, string $expectedContent, SplFileInfo $fixtureFileInfo): void
    {
        $convertedContent = $this->configFormatConverter->convert($inputFileInfo);
        FixtureUpdater::updateFixtureContent($inputFileInfo, $convertedContent, $fixtureFileInfo);

        $filePath = RelativeFilePathHelper::resolveFromDirectory($fixtureFileInfo->getRealPath(), getcwd());

        $this->assertSame($expectedContent, $convertedContent, $filePath);
    }

    private function doTestOutputWithExtraDirectory(SplFileInfo $fixtureFileInfo, string $extraDirectory): void
    {
        $inputAndExpected = FixtureSplitter::splitFileInfoToInputAndExpected($fixtureFileInfo);
        $temporaryPath = FixtureSplitter::getTemporaryPath();

        // copy /src to temp directory, so Symfony FileLocator knows about it
        $fileSystem = new \Symfony\Component\Filesystem\Filesystem();
        $fileSystem->mirror($extraDirectory, $temporaryPath, null, [
            'override' => true,
        ]);

        $fileTemporaryPath = $temporaryPath . '/' . RelativeFilePathHelper::resolveFromDirectory($fixtureFileInfo->getRealPath(), $extraDirectory);

        FileSystem::write($fileTemporaryPath, $inputAndExpected->getInput());

        // require class to autoload it
        $expectedFilePath = $temporaryPath . '/src/SomeClass.php';
        $this->assertFileExists($expectedFilePath);

        require_once $expectedFilePath;

        $inputFileInfo = new SplFileInfo($fileTemporaryPath, '', '');
        $this->doTestFileInfo($inputFileInfo, $inputAndExpected->getExpected(), $fixtureFileInfo);
    }
}
