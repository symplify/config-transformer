<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Tests\Converter\ConfigFormatConverter;

abstract class AbstractConfigFormatConverterTestCase extends \Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    protected \Symplify\ConfigTransformer\Converter\ConfigFormatConverter $configFormatConverter;

    protected \Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem;

    protected function setUp(): void
    {
        $this->bootKernel(\Symplify\ConfigTransformer\Kernel\ConfigTransformerKernel::class);
        $this->configFormatConverter = $this->getService(\Symplify\ConfigTransformer\Converter\ConfigFormatConverter::class);
        $this->smartFileSystem = $this->getService(\Symplify\SmartFileSystem\SmartFileSystem::class);
    }

    protected function doTestOutput(\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo, bool $preserveDirStructure = false): void
    {
        $inputAndExpected = \Symplify\EasyTesting\StaticFixtureSplitter::splitFileInfoToLocalInputAndExpectedFileInfos($fixtureFileInfo, false, $preserveDirStructure);
        $this->doTestFileInfo($inputAndExpected->getInputFileInfo(), $inputAndExpected->getExpectedFileContent(), $fixtureFileInfo);
    }

    protected function doTestFileInfo(\Symplify\SmartFileSystem\SmartFileInfo $inputFileInfo, string $expectedContent, \Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo): void
    {
        $convertedContent = $this->configFormatConverter->convert($inputFileInfo);
        \Symplify\EasyTesting\DataProvider\StaticFixtureUpdater::updateFixtureContent($inputFileInfo, $convertedContent, $fixtureFileInfo);
        $this->assertSame($expectedContent, $convertedContent, $fixtureFileInfo->getRelativeFilePathFromCwd());
    }
}
