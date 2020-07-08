<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\Tests\Converter\ConfigFormatConverter;

use Iterator;
use Migrify\ConfigTransformer\Converter\ConfigFormatConverter;
use Migrify\ConfigTransformer\DependencyInjection\ContainerBuilderCleaner;
use Migrify\ConfigTransformer\HttpKernel\ConfigTransformerKernel;
use Nette\Utils\FileSystem;
use Rector\Core\Testing\ValueObject\SplitLine;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use Symplify\EasyTesting\StaticFixtureSplitter;
use Symplify\PackageBuilder\Tests\AbstractKernelTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;

final class ConfigFormatConverterTest extends AbstractKernelTestCase
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

    /**
     * @dataProvider provideData()
     */
    public function test(SmartFileInfo $fixtureFileInfo): void
    {
        [$inputFileInfo, $expectedFileInfo] = StaticFixtureSplitter::splitFileInfoToLocalInputAndExpectedFileInfos(
            $fixtureFileInfo
        );

        $convertedContent = $this->configFormatConverter->convert($inputFileInfo, 'yaml');

        $this->updateFixture($fixtureFileInfo, $inputFileInfo, $convertedContent);
        $this->assertSame(
            $expectedFileInfo->getContents(),
            $convertedContent,
            $fixtureFileInfo->getRelativeFilePathFromCwd()
        );

        $this->doTestYamlContentIsLoadable($convertedContent);
    }

    public function provideData(): Iterator
    {
        return StaticFixtureFinder::yieldDirectory(__DIR__ . '/Fixture', '*.xml');
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

    private function doTestYamlContentIsLoadable(string $yamlContent): void
    {
        $containerBuilder = new ContainerBuilder();

        $localYamlFile = sys_get_temp_dir() . '/_migrify_temporary_yaml/some_file.yaml';
        FileSystem::write($localYamlFile, $yamlContent);

        $yamlFileLoader = new YamlFileLoader($containerBuilder, new FileLocator());
        $yamlFileLoader->load($localYamlFile);

        $this->containerBuilderCleaner->cleanContainerBuilder($containerBuilder);

        // at least 1 service is registered
        $definitionCount = count($containerBuilder->getDefinitions());
        $this->assertGreaterThanOrEqual(1, $definitionCount);
    }
}
