<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter;

use Migrify\ConfigTransformer\FormatSwitcher\ConfigLoader;
use Migrify\ConfigTransformer\FormatSwitcher\DependencyInjection\ContainerBuilderCleaner;
use Migrify\ConfigTransformer\FormatSwitcher\DumperFactory;
use Migrify\ConfigTransformer\FormatSwitcher\DumperFomatter\YamlDumpFormatter;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\NotImplementedYetException;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\ShouldNotHappenException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symplify\SmartFileSystem\SmartFileInfo;

/**
 * @see \Migrify\ConfigTransformer\FormatSwitcher\Tests\Converter\ConfigFormatConverter\ConfigFormatConverterTest
 */
final class ConfigFormatConverter
{
    /**
     * @var ConfigLoader
     */
    private $configLoader;

    /**
     * @var DumperFactory
     */
    private $dumperFactory;

    /**
     * @var ContainerBuilderCleaner
     */
    private $containerBuilderCleaner;

    /**
     * @var YamlDumpFormatter
     */
    private $yamlDumpFormatter;

    /**
     * @var YamlToPhpConverter
     */
    private $yamlToPhpConverter;

    public function __construct(
        ConfigLoader $configLoader,
        DumperFactory $dumperFactory,
        ContainerBuilderCleaner $containerBuilderCleaner,
        YamlDumpFormatter $yamlDumpFormatter,
        YamlToPhpConverter $yamlToPhpConverter
    ) {
        $this->configLoader = $configLoader;
        $this->dumperFactory = $dumperFactory;
        $this->containerBuilderCleaner = $containerBuilderCleaner;
        $this->yamlDumpFormatter = $yamlDumpFormatter;
        $this->yamlToPhpConverter = $yamlToPhpConverter;
    }

    public function convert(SmartFileInfo $smartFileInfo, string $outputFormat): string
    {
        $containerBuilder = $this->configLoader->createAndLoadContainerBuilderFromFileInfo($smartFileInfo);

        if ($outputFormat === 'yaml') {
            return $this->convertToYaml($containerBuilder);
        }

        if ($outputFormat === 'php') {
            $yamlContent = $this->convertToYaml($containerBuilder);
            return $this->yamlToPhpConverter->convert($yamlContent);
        }

        throw new NotImplementedYetException($outputFormat);
    }

    private function convertToYaml(ContainerBuilder $containerBuilder): string
    {
        $dumper = $this->dumperFactory->createFromContainerBuilderAndOutputFormat($containerBuilder, 'yaml');

        $this->containerBuilderCleaner->cleanContainerBuilder($containerBuilder);

        $content = $dumper->dump();
        if (! is_string($content)) {
            throw new ShouldNotHappenException();
        }

        return $this->yamlDumpFormatter->format($content);
    }
}
