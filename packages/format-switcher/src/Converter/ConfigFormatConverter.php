<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter;

use Migrify\ConfigTransformer\FormatSwitcher\ConfigLoader;
use Migrify\ConfigTransformer\FormatSwitcher\DependencyInjection\ContainerBuilderCleaner;
use Migrify\ConfigTransformer\FormatSwitcher\DumperFactory;
use Migrify\ConfigTransformer\FormatSwitcher\DumperFomatter\YamlDumpFormatter;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\NotImplementedYetException;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\ShouldNotHappenException;
use Migrify\ConfigTransformer\FormatSwitcher\Provider\CurrentFilePathProvider;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\Format;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symplify\SmartFileSystem\SmartFileInfo;

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

    /**
     * @var CurrentFilePathProvider
     */
    private $currentFilePathProvider;

    public function __construct(
        ConfigLoader $configLoader,
        DumperFactory $dumperFactory,
        ContainerBuilderCleaner $containerBuilderCleaner,
        YamlDumpFormatter $yamlDumpFormatter,
        YamlToPhpConverter $yamlToPhpConverter,
        CurrentFilePathProvider $currentFilePathProvider
    ) {
        $this->configLoader = $configLoader;
        $this->dumperFactory = $dumperFactory;
        $this->containerBuilderCleaner = $containerBuilderCleaner;
        $this->yamlDumpFormatter = $yamlDumpFormatter;
        $this->yamlToPhpConverter = $yamlToPhpConverter;
        $this->currentFilePathProvider = $currentFilePathProvider;
    }

    public function convert(SmartFileInfo $smartFileInfo, string $inputFormat, string $outputFormat): string
    {
        $this->currentFilePathProvider->setFilePath($smartFileInfo->getRealPath());

        $containerBuilder = $this->configLoader->createAndLoadContainerBuilderFromFileInfo($smartFileInfo);
        if ($outputFormat === Format::YAML) {
            return $this->dumpContainerBuilderToYaml($containerBuilder);
        }

        if ($outputFormat === Format::PHP) {
            if ($inputFormat === Format::YAML) {
                return $this->yamlToPhpConverter->convert($smartFileInfo->getContents());
            }

            if ($inputFormat === Format::XML) {
                $yamlContent = $this->dumpContainerBuilderToYaml($containerBuilder);
                return $this->yamlToPhpConverter->convert($yamlContent);
            }
        }

        throw new NotImplementedYetException($outputFormat);
    }

    private function dumpContainerBuilderToYaml(ContainerBuilder $containerBuilder): string
    {
        $dumper = $this->dumperFactory->createFromContainerBuilderAndOutputFormat($containerBuilder, Format::YAML);
        $this->containerBuilderCleaner->cleanContainerBuilder($containerBuilder);

        $content = $dumper->dump();
        if (! is_string($content)) {
            throw new ShouldNotHappenException();
        }

        return $this->yamlDumpFormatter->format($content);
    }
}
