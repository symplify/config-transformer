<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\Converter;

use Migrify\ConfigTransformer\ConfigLoader;
use Migrify\ConfigTransformer\DependencyInjection\ContainerBuilderCleaner;
use Migrify\ConfigTransformer\DumperFactory;
use Migrify\ConfigTransformer\DumperFomatter\YamlDumpFormatter;
use Migrify\ConfigTransformer\Exception\ShouldNotHappenException;
use Symplify\SmartFileSystem\SmartFileInfo;

/**
 * @see \Migrify\ConfigTransformer\Tests\Converter\ConfigTransformer\ConfigTransformerTest
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
