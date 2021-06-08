<?php

declare (strict_types=1);
namespace ConfigTransformer20210608\Symplify\ConfigTransformer\Converter;

use ConfigTransformer20210608\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer20210608\Symfony\Component\DependencyInjection\Dumper\YamlDumper;
use ConfigTransformer20210608\Symfony\Component\Yaml\Yaml;
use ConfigTransformer20210608\Symplify\ConfigTransformer\Collector\XmlImportCollector;
use ConfigTransformer20210608\Symplify\ConfigTransformer\ConfigLoader;
use ConfigTransformer20210608\Symplify\ConfigTransformer\DependencyInjection\ContainerBuilderCleaner;
use ConfigTransformer20210608\Symplify\ConfigTransformer\ValueObject\Format;
use ConfigTransformer20210608\Symplify\PackageBuilder\Exception\NotImplementedYetException;
use ConfigTransformer20210608\Symplify\PhpConfigPrinter\Provider\CurrentFilePathProvider;
use ConfigTransformer20210608\Symplify\PhpConfigPrinter\YamlToPhpConverter;
use ConfigTransformer20210608\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer20210608\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class ConfigFormatConverter
{
    /**
     * @var ConfigLoader
     */
    private $configLoader;
    /**
     * @var YamlToPhpConverter
     */
    private $yamlToPhpConverter;
    /**
     * @var CurrentFilePathProvider
     */
    private $currentFilePathProvider;
    /**
     * @var XmlImportCollector
     */
    private $xmlImportCollector;
    /**
     * @var ContainerBuilderCleaner
     */
    private $containerBuilderCleaner;
    public function __construct(\ConfigTransformer20210608\Symplify\ConfigTransformer\ConfigLoader $configLoader, \ConfigTransformer20210608\Symplify\PhpConfigPrinter\YamlToPhpConverter $yamlToPhpConverter, \ConfigTransformer20210608\Symplify\PhpConfigPrinter\Provider\CurrentFilePathProvider $currentFilePathProvider, \ConfigTransformer20210608\Symplify\ConfigTransformer\Collector\XmlImportCollector $xmlImportCollector, \ConfigTransformer20210608\Symplify\ConfigTransformer\DependencyInjection\ContainerBuilderCleaner $containerBuilderCleaner)
    {
        $this->configLoader = $configLoader;
        $this->yamlToPhpConverter = $yamlToPhpConverter;
        $this->currentFilePathProvider = $currentFilePathProvider;
        $this->xmlImportCollector = $xmlImportCollector;
        $this->containerBuilderCleaner = $containerBuilderCleaner;
    }
    public function convert(\ConfigTransformer20210608\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        $this->currentFilePathProvider->setFilePath($smartFileInfo->getRealPath());
        $containerBuilderAndFileContent = $this->configLoader->createAndLoadContainerBuilderFromFileInfo($smartFileInfo);
        $containerBuilder = $containerBuilderAndFileContent->getContainerBuilder();
        if ($smartFileInfo->getSuffix() === \ConfigTransformer20210608\Symplify\ConfigTransformer\ValueObject\Format::YAML) {
            $dumpedYaml = $containerBuilderAndFileContent->getFileContent();
            $dumpedYaml = $this->decorateWithCollectedXmlImports($dumpedYaml);
            return $this->yamlToPhpConverter->convert($dumpedYaml);
        }
        if ($smartFileInfo->getSuffix() === \ConfigTransformer20210608\Symplify\ConfigTransformer\ValueObject\Format::XML) {
            $dumpedYaml = $this->dumpContainerBuilderToYaml($containerBuilder);
            $dumpedYaml = $this->decorateWithCollectedXmlImports($dumpedYaml);
            return $this->yamlToPhpConverter->convert($dumpedYaml);
        }
        $message = \sprintf('Suffix "%s" is not support yet', $smartFileInfo->getSuffix());
        throw new \ConfigTransformer20210608\Symplify\PackageBuilder\Exception\NotImplementedYetException($message);
    }
    private function dumpContainerBuilderToYaml(\ConfigTransformer20210608\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : string
    {
        $yamlDumper = new \ConfigTransformer20210608\Symfony\Component\DependencyInjection\Dumper\YamlDumper($containerBuilder);
        $this->containerBuilderCleaner->cleanContainerBuilder($containerBuilder);
        $content = $yamlDumper->dump();
        if (!\is_string($content)) {
            throw new \ConfigTransformer20210608\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $content;
    }
    private function decorateWithCollectedXmlImports(string $dumpedYaml) : string
    {
        $collectedXmlImports = $this->xmlImportCollector->provide();
        if ($collectedXmlImports === []) {
            return $dumpedYaml;
        }
        $yamlArray = \ConfigTransformer20210608\Symfony\Component\Yaml\Yaml::parse($dumpedYaml, \ConfigTransformer20210608\Symfony\Component\Yaml\Yaml::PARSE_CUSTOM_TAGS);
        $yamlArray['imports'] = \array_merge($yamlArray['imports'] ?? [], $collectedXmlImports);
        return \ConfigTransformer20210608\Symfony\Component\Yaml\Yaml::dump($yamlArray, 10, 4, \ConfigTransformer20210608\Symfony\Component\Yaml\Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);
    }
}
