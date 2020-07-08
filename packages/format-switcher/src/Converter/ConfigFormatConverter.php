<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter;

use Migrify\ConfigTransformer\FormatSwitcher\ConfigLoader;
use Migrify\ConfigTransformer\FormatSwitcher\DependencyInjection\ContainerBuilderCleaner;
use Migrify\ConfigTransformer\FormatSwitcher\DumperFactory;
use Migrify\ConfigTransformer\FormatSwitcher\DumperFomatter\YamlDumpFormatter;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\ShouldNotHappenException;
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

    public function __construct(
        ConfigLoader $configLoader,
        DumperFactory $dumperFactory,
        ContainerBuilderCleaner $containerBuilderCleaner,
        YamlDumpFormatter $yamlDumpFormatter
    ) {
        $this->configLoader = $configLoader;
        $this->dumperFactory = $dumperFactory;
        $this->containerBuilderCleaner = $containerBuilderCleaner;
        $this->yamlDumpFormatter = $yamlDumpFormatter;
    }

    public function convert(SmartFileInfo $smartFileInfo, string $outputFormat): string
    {
        $containerBuilder = $this->configLoader->loadContainerBuilderFromFileInfo($smartFileInfo);
        $this->containerBuilderCleaner->cleanContainerBuilder($containerBuilder);

        $dumper = $this->dumperFactory->createFromContainerBuilderAndOutputFormat(
            $containerBuilder,
            $outputFormat
        );

        $content = $dumper->dump();
        if (! is_string($content)) {
            throw new ShouldNotHappenException();
        }

        return $this->yamlDumpFormatter->format($content);
    }
}
