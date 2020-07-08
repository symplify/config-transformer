<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Tests\Converter\ConfigFormatConverter;

use Migrify\ConfigTransformer\FormatSwitcher\Converter\ConfigFormatConverter;
use Migrify\ConfigTransformer\FormatSwitcher\DependencyInjection\ContainerBuilderCleaner;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\NotImplementedYetException;
use Migrify\ConfigTransformer\HttpKernel\ConfigTransformerKernel;
use Nette\Utils\FileSystem;
use Rector\Core\Testing\ValueObject\SplitLine;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\FileLoader;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symplify\EasyTesting\StaticFixtureSplitter;
use Symplify\PackageBuilder\Tests\AbstractKernelTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;

abstract class AbstractConfigFormatConverterTest extends AbstractKernelTestCase
{
    /**
     * @var ConfigFormatConverter
     */
    private $configFormatConverter;

    /**
     * @var ContainerBuilderCleaner
     */
    private $containerBuilderCleaner;

    protected function setUp(): void
    {
        $this->bootKernel(ConfigTransformerKernel::class);

        $this->configFormatConverter = self::$container->get(ConfigFormatConverter::class);
        $this->containerBuilderCleaner = self::$container->get(ContainerBuilderCleaner::class);
    }

    protected function doTestOutput(SmartFileInfo $fixtureFileInfo, string $outputFormat): void
    {
        [$inputFileInfo, $expectedFileInfo] = StaticFixtureSplitter::splitFileInfoToLocalInputAndExpectedFileInfos(
            $fixtureFileInfo
        );

        $convertedContent = $this->configFormatConverter->convert($inputFileInfo, $outputFormat);

        $this->updateFixture($fixtureFileInfo, $inputFileInfo, $convertedContent);
        $this->assertSame(
            $expectedFileInfo->getContents(),
            $convertedContent,
            $fixtureFileInfo->getRelativeFilePathFromCwd()
        );

        $this->doTestContentIsLoadable($convertedContent, $outputFormat);
    }

    /**
     * @todo decouple to migrify/easy-testing
     */
    private function updateFixture(
        SmartFileInfo $fileInfo,
        SmartFileInfo $inputFileInfo,
        string $convertedContent
    ): void {
        if (! getenv('UPDATE_TESTS')) {
            return;
        }

        $newOriginalContent = $inputFileInfo->getContents() . SplitLine::LINE . rtrim($convertedContent) . PHP_EOL;
        FileSystem::write($fileInfo->getRealPath(), $newOriginalContent);
    }

    private function doTestContentIsLoadable(string $yamlContent, string $format): void
    {
        $localFile = sys_get_temp_dir() . '/_migrify_temporary_yaml/some_file.yaml';
        FileSystem::write($localFile, $yamlContent);

        $containerBuilder = new ContainerBuilder();
        $fileLoader = $this->createFileLoader($format, $containerBuilder);
        $fileLoader->load($localFile);

        $this->containerBuilderCleaner->cleanContainerBuilder($containerBuilder);

        // at least 1 service is registered
        $definitionCount = count($containerBuilder->getDefinitions());
        $this->assertGreaterThanOrEqual(1, $definitionCount);
    }

    private function createFileLoader(string $format, ContainerBuilder $containerBuilder): FileLoader
    {
        if ($format === 'yaml') {
            return new YamlFileLoader($containerBuilder, new FileLocator());
        }

        if ($format === 'php') {
            return new PhpFileLoader($containerBuilder, new FileLocator());
        }

        throw new NotImplementedYetException($format);
    }
}
