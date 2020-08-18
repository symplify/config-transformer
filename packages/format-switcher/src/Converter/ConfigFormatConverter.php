<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter;

use Migrify\ConfigTransformer\FormatSwitcher\ConfigLoader;
use Migrify\ConfigTransformer\FormatSwitcher\DependencyInjection\ContainerBuilderCleaner;
use Migrify\ConfigTransformer\FormatSwitcher\DumperFactory;
use Migrify\ConfigTransformer\FormatSwitcher\DumperFomatter\YamlDumpFormatter;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\NotImplementedYetException;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\ShouldNotHappenException;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\Format;
use Migrify\PhpConfigPrinter\CaseConverter\YamlToPhpConverter;
use Migrify\PhpConfigPrinter\Provider\CurrentFilePathProvider;
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

        $containerBuilderAndFileContent = $this->configLoader->createAndLoadContainerBuilderFromFileInfo(
            $smartFileInfo
        );

        $containerBuilder = $containerBuilderAndFileContent->getContainerBuilder();
        if ($outputFormat === Format::YAML) {
            return $this->dumpContainerBuilderToYaml($containerBuilder);
        }

        if ($outputFormat === Format::PHP) {
            if ($inputFormat === Format::YAML) {
                return $this->yamlToPhpConverter->convert($containerBuilderAndFileContent->getFileContent());
            }

            if ($inputFormat === Format::XML) {
                $yamlContent = $this->dumpContainerBuilderToYaml($containerBuilder);
                return $this->yamlToPhpConverter->convert($yamlContent);
            }
        }

        $message = sprintf('Converting from %s to %s it not support yet', $inputFormat, $outputFormat);
        throw new NotImplementedYetException($message);
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
