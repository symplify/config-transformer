<?php

declare (strict_types=1);
namespace ConfigTransformer202107130\Symplify\ConfigTransformer\Converter;

use ConfigTransformer202107130\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202107130\Symfony\Component\DependencyInjection\Dumper\YamlDumper;
use ConfigTransformer202107130\Symfony\Component\Yaml\Yaml;
use ConfigTransformer202107130\Symplify\ConfigTransformer\Collector\XmlImportCollector;
use ConfigTransformer202107130\Symplify\ConfigTransformer\ConfigLoader;
use ConfigTransformer202107130\Symplify\ConfigTransformer\DependencyInjection\ContainerBuilderCleaner;
use ConfigTransformer202107130\Symplify\ConfigTransformer\ValueObject\Format;
use ConfigTransformer202107130\Symplify\PackageBuilder\Exception\NotImplementedYetException;
use ConfigTransformer202107130\Symplify\PhpConfigPrinter\Provider\CurrentFilePathProvider;
use ConfigTransformer202107130\Symplify\PhpConfigPrinter\YamlToPhpConverter;
use ConfigTransformer202107130\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer202107130\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class ConfigFormatConverter
{
    /**
     * @var \Symplify\ConfigTransformer\ConfigLoader
     */
    private $configLoader;
    /**
     * @var \Symplify\PhpConfigPrinter\YamlToPhpConverter
     */
    private $yamlToPhpConverter;
    /**
     * @var \Symplify\PhpConfigPrinter\Provider\CurrentFilePathProvider
     */
    private $currentFilePathProvider;
    /**
     * @var \Symplify\ConfigTransformer\Collector\XmlImportCollector
     */
    private $xmlImportCollector;
    /**
     * @var \Symplify\ConfigTransformer\DependencyInjection\ContainerBuilderCleaner
     */
    private $containerBuilderCleaner;
    public function __construct(\ConfigTransformer202107130\Symplify\ConfigTransformer\ConfigLoader $configLoader, \ConfigTransformer202107130\Symplify\PhpConfigPrinter\YamlToPhpConverter $yamlToPhpConverter, \ConfigTransformer202107130\Symplify\PhpConfigPrinter\Provider\CurrentFilePathProvider $currentFilePathProvider, \ConfigTransformer202107130\Symplify\ConfigTransformer\Collector\XmlImportCollector $xmlImportCollector, \ConfigTransformer202107130\Symplify\ConfigTransformer\DependencyInjection\ContainerBuilderCleaner $containerBuilderCleaner)
    {
        $this->configLoader = $configLoader;
        $this->yamlToPhpConverter = $yamlToPhpConverter;
        $this->currentFilePathProvider = $currentFilePathProvider;
        $this->xmlImportCollector = $xmlImportCollector;
        $this->containerBuilderCleaner = $containerBuilderCleaner;
    }
    public function convert(\ConfigTransformer202107130\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        $this->currentFilePathProvider->setFilePath($smartFileInfo->getRealPath());
        $containerBuilderAndFileContent = $this->configLoader->createAndLoadContainerBuilderFromFileInfo($smartFileInfo);
        $containerBuilder = $containerBuilderAndFileContent->getContainerBuilder();
        if ($smartFileInfo->getSuffix() === \ConfigTransformer202107130\Symplify\ConfigTransformer\ValueObject\Format::YAML) {
            $dumpedYaml = $containerBuilderAndFileContent->getFileContent();
            $dumpedYaml = $this->decorateWithCollectedXmlImports($dumpedYaml);
            return $this->yamlToPhpConverter->convert($dumpedYaml);
        }
        if ($smartFileInfo->getSuffix() === \ConfigTransformer202107130\Symplify\ConfigTransformer\ValueObject\Format::XML) {
            $dumpedYaml = $this->dumpContainerBuilderToYaml($containerBuilder);
            $dumpedYaml = $this->decorateWithCollectedXmlImports($dumpedYaml);
            return $this->yamlToPhpConverter->convert($dumpedYaml);
        }
        $message = \sprintf('Suffix "%s" is not support yet', $smartFileInfo->getSuffix());
        throw new \ConfigTransformer202107130\Symplify\PackageBuilder\Exception\NotImplementedYetException($message);
    }
    private function dumpContainerBuilderToYaml(\ConfigTransformer202107130\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : string
    {
        $yamlDumper = new \ConfigTransformer202107130\Symfony\Component\DependencyInjection\Dumper\YamlDumper($containerBuilder);
        $this->containerBuilderCleaner->cleanContainerBuilder($containerBuilder);
        $content = $yamlDumper->dump();
        if (!\is_string($content)) {
            throw new \ConfigTransformer202107130\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $content;
    }
    private function decorateWithCollectedXmlImports(string $dumpedYaml) : string
    {
        $collectedXmlImports = $this->xmlImportCollector->provide();
        if ($collectedXmlImports === []) {
            return $dumpedYaml;
        }
        $yamlArray = \ConfigTransformer202107130\Symfony\Component\Yaml\Yaml::parse($dumpedYaml, \ConfigTransformer202107130\Symfony\Component\Yaml\Yaml::PARSE_CUSTOM_TAGS);
        $yamlArray['imports'] = \array_merge($yamlArray['imports'] ?? [], $collectedXmlImports);
        return \ConfigTransformer202107130\Symfony\Component\Yaml\Yaml::dump($yamlArray, 10, 4, \ConfigTransformer202107130\Symfony\Component\Yaml\Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);
    }
}
