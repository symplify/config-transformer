<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Tests\Converter\ConfigFormatConverter;

use Migrify\ConfigTransformer\FormatSwitcher\Configuration\Configuration;
use Migrify\ConfigTransformer\FormatSwitcher\Converter\ConfigFormatConverter;
use Migrify\ConfigTransformer\FormatSwitcher\DependencyInjection\ContainerBuilderCleaner;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\Format;
use Migrify\ConfigTransformer\HttpKernel\ConfigTransformerKernel;
use Rector\Core\Testing\ValueObject\SplitLine;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symplify\EasyTesting\StaticFixtureSplitter;
use Symplify\PackageBuilder\Tests\AbstractKernelTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;

abstract class AbstractConfigFormatConverterTest extends AbstractKernelTestCase
{
    /**
     * @var ConfigFormatConverter
     */
    protected $configFormatConverter;

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var ContainerBuilderCleaner
     */
    private $containerBuilderCleaner;

    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;

    protected function setUp(): void
    {
        $this->bootKernel(ConfigTransformerKernel::class);

        $this->configFormatConverter = self::$container->get(ConfigFormatConverter::class);
        $this->containerBuilderCleaner = self::$container->get(ContainerBuilderCleaner::class);
        $this->smartFileSystem = self::$container->get(SmartFileSystem::class);
        $this->configuration = self::$container->get(Configuration::class);
    }

    protected function doTestOutput(SmartFileInfo $fixtureFileInfo, string $inputFormat, string $outputFormat): void
    {
        $this->configuration->changeInputFormat($inputFormat);
        $this->configuration->changeOutputFormat($outputFormat);

        [$inputFileInfo, $expectedFileInfo] = StaticFixtureSplitter::splitFileInfoToLocalInputAndExpectedFileInfos(
            $fixtureFileInfo
        );

        $this->doTestFileInfo(
            $inputFileInfo,
            $expectedFileInfo->getContents(),
            $fixtureFileInfo,
            $inputFormat,
            $outputFormat
        );
    }

    /**
     * @todo decouple to migrify/easy-testing
     */
    protected function updateFixture(
        SmartFileInfo $fileInfo,
        SmartFileInfo $inputFileInfo,
        string $convertedContent
    ): void {
        if (! getenv('UPDATE_TESTS')) {
            return;
        }

        $newOriginalContent = rtrim($inputFileInfo->getContents()) . PHP_EOL . SplitLine::LINE . rtrim(
            $convertedContent
        ) . PHP_EOL;

        $this->smartFileSystem->dumpFile($fileInfo->getRealPath(), $newOriginalContent);
    }

    protected function doTestYamlContentIsLoadable(string $yamlContent): void
    {
        $localFile = sys_get_temp_dir() . '/_migrify_temporary_yaml/some_file.yaml';
        $this->smartFileSystem->dumpFile($localFile, $yamlContent);

        $containerBuilder = new ContainerBuilder();
        $yamlFileLoader = new YamlFileLoader($containerBuilder, new FileLocator());
        $yamlFileLoader->load($localFile);

        $this->containerBuilderCleaner->cleanContainerBuilder($containerBuilder);

        // at least 1 service is registered
        $definitionCount = count($containerBuilder->getDefinitions());
        $this->assertGreaterThanOrEqual(1, $definitionCount);
    }

    protected function doTestFileInfo(
        SmartFileInfo $inputFileInfo,
        string $expectedContent,
        SmartFileInfo $fixtureFileInfo,
        string $inputFormat,
        string $outputFormat
    ): void {
        $convertedContent = $this->configFormatConverter->convert($inputFileInfo, $inputFormat, $outputFormat);

        $this->updateFixture($fixtureFileInfo, $inputFileInfo, $convertedContent);
        $this->assertSame($expectedContent, $convertedContent, $fixtureFileInfo->getRelativeFilePathFromCwd());

        if ($outputFormat === Format::YAML) {
            $this->doTestYamlContentIsLoadable($convertedContent);
        }
    }
}
