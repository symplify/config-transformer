<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Tests\Converter\ConfigFormatConverter\YamlToPhp;

use Iterator;
use Nette\Utils\FileSystem;
use PHPUnit\Framework\Attributes\DataProvider;
use Symplify\ConfigTransformer\Tests\Converter\ConfigFormatConverter\AbstractConfigFormatConverterTestCase;
use Symplify\ConfigTransformer\Tests\Helper\FixtureFinder;

final class YamlToPhpTest extends AbstractConfigFormatConverterTestCase
{
    #[DataProvider('provideDataForRouting')]
    public function testRouting(\SplFileInfo $fileInfo): void
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
    public function testNormal(\SplFileInfo $fixtureFileInfo): void
    {
        // for imports
        $temporaryPath = StaticFixtureSplitter::getTemporaryPath();
        $this->smartFileSystem->mirror(__DIR__ . '/Fixture/normal', $temporaryPath);

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
    public function testSpecialCaseWithDirectory(\SplFileInfo $fileInfo): void
    {
        $this->doTestOutputWithExtraDirectory($fileInfo, __DIR__ . '/Fixture/nested');
    }

    #[DataProvider('provideDataExtension')]
    public function testEcs(\SplFileInfo $fileInfo): void
    {
        $this->doTestOutputWithExtraDirectory($fileInfo, $fileInfo->getPath());
    }

    /**
     * @source https://github.com/symfony/maker-bundle/pull/604
     */
    #[DataProvider('provideDataMakerBundle')]
    public function testMakerBundle(\SplFileInfo $fileInfo): void
    {
        // needed for all the included
        $temporaryPath = StaticFixtureSplitter::getTemporaryPath();
        $this->smartFileSystem->dumpFile(
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
     * @return Iterator<mixed, \SplFileInfo[]>
     */
    public static function provideDataMakerBundle(): Iterator
    {
        return FixtureFinder::yieldDirectory(__DIR__ . '/Fixture/maker-bundle', '*.yaml');
    }

    private function doTestOutputWithExtraDirectory(\SplFileInfo $fixtureFileInfo, string $extraDirectory): void
    {
        $inputAndExpected = StaticFixtureSplitter::splitFileInfoToInputAndExpected($fixtureFileInfo);
        $temporaryPath = StaticFixtureSplitter::getTemporaryPath();

        // copy /src to temp directory, so Symfony FileLocator knows about it
        $this->smartFileSystem->mirror($extraDirectory, $temporaryPath, null, [
            'override' => true,
        ]);

        $fileTemporaryPath = $temporaryPath . '/' . $fixtureFileInfo->getRelativeFilePathFromDirectory($extraDirectory);
        FileSystem::write($fileTemporaryPath, $inputAndExpected->getInput());

        // require class to autoload it
        $expectedFilePath = $temporaryPath . '/src/SomeClass.php';
        $this->assertFileExists($expectedFilePath);

        require_once $expectedFilePath;

        $inputFileInfo = new \SplFileInfo($fileTemporaryPath);

        $this->doTestFileInfo($inputFileInfo, $inputAndExpected->getExpected(), $fixtureFileInfo);
    }
}
