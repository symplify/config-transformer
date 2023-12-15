<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Tests\Converter\ConfigFormatConverter;

use Nette\Utils\FileSystem;
use Symplify\ConfigTransformer\Converter\ConfigFormatConverter;
<<<<<<< HEAD
use Symplify\ConfigTransformer\Kernel\ConfigTransformerKernel;
<<<<<<< HEAD
=======
use Symplify\ConfigTransformer\Tests\AbstractTestCase;
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> af077e6 (fixup! bump)
=======
use Symplify\ConfigTransformer\Tests\AbstractTestCase;
>>>>>>> cd67f40 (bump)
use Symplify\EasyTesting\DataProvider\StaticFixtureUpdater;
use Symplify\EasyTesting\StaticFixtureSplitter;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;
=======
>>>>>>> 19a2662 (fixup! fixup! bump)
=======
use Symplify\ConfigTransformer\Tests\Helper\FixtureSplitter;
>>>>>>> 257b8ab (fixup! fixup! fixup! fixup! fixup! fixup! fixup! fixup! bump)

abstract class AbstractConfigFormatConverterTestCase extends AbstractTestCase
{
    protected ConfigFormatConverter $configFormatConverter;

    protected FileSystem $smartFileSystem;

    protected function setUp(): void
    {
<<<<<<< HEAD
<<<<<<< HEAD
        $this->bootKernel(ConfigTransformerKernel::class);
        $this->configFormatConverter = $this->getService(ConfigFormatConverter::class);
        $this->smartFileSystem = $this->getService(SmartFileSystem::class);
=======
        $this->configFormatConverter = $this->container->get(ConfigFormatConverter::class);
        $this->smartFileSystem = $this->container->get(FileSystem::class);
>>>>>>> 19a2662 (fixup! fixup! bump)
=======
        $this->configFormatConverter = $this->container->get(ConfigFormatConverter::class);
        $this->smartFileSystem = $this->container->get(SmartFileSystem::class);
>>>>>>> cd67f40 (bump)
    }

    protected function doTestOutput(\SplFileInfo $fixtureFileInfo, bool $preserveDirStructure = false): void
    {
        $inputAndExpected = FixtureSplitter::splitFileInfoToLocalInputAndExpectedFileInfos($fixtureFileInfo, false, $preserveDirStructure);
        $this->doTestFileInfo($inputAndExpected->getInputFileInfo(), $inputAndExpected->getExpectedFileContent(), $fixtureFileInfo);
    }

    protected function doTestFileInfo(\SplFileInfo $inputFileInfo, string $expectedContent, \SplFileInfo $fixtureFileInfo): void
    {
        $convertedContent = $this->configFormatConverter->convert($inputFileInfo);
        StaticFixtureUpdater::updateFixtureContent($inputFileInfo, $convertedContent, $fixtureFileInfo);

        $this->assertSame($expectedContent, $convertedContent, $fixtureFileInfo->getRelativeFilePathFromCwd());
    }
}
