<?php

declare (strict_types=1);
namespace ConfigTransformer2021093010\Symplify\ConfigTransformer\Converter;

use ConfigTransformer2021093010\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2021093010\Symfony\Component\DependencyInjection\Dumper\YamlDumper;
use ConfigTransformer2021093010\Symfony\Component\Yaml\Yaml;
use ConfigTransformer2021093010\Symplify\ConfigTransformer\Collector\XmlImportCollector;
use ConfigTransformer2021093010\Symplify\ConfigTransformer\ConfigLoader;
use ConfigTransformer2021093010\Symplify\ConfigTransformer\DependencyInjection\ContainerBuilderCleaner;
use ConfigTransformer2021093010\Symplify\ConfigTransformer\ValueObject\Configuration;
use ConfigTransformer2021093010\Symplify\ConfigTransformer\ValueObject\Format;
use ConfigTransformer2021093010\Symplify\PackageBuilder\Exception\NotImplementedYetException;
use ConfigTransformer2021093010\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use ConfigTransformer2021093010\Symplify\PackageBuilder\Yaml\ParametersMerger;
use ConfigTransformer2021093010\Symplify\PhpConfigPrinter\Provider\CurrentFilePathProvider;
use ConfigTransformer2021093010\Symplify\PhpConfigPrinter\YamlToPhpConverter;
use ConfigTransformer2021093010\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer2021093010\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
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
    /**
     * @var \Symplify\PackageBuilder\Reflection\PrivatesAccessor
     */
    private $privatesAccessor;
    /**
     * @var \Symplify\PackageBuilder\Yaml\ParametersMerger
     */
    private $parametersMerger;
    public function __construct(\ConfigTransformer2021093010\Symplify\ConfigTransformer\ConfigLoader $configLoader, \ConfigTransformer2021093010\Symplify\PhpConfigPrinter\YamlToPhpConverter $yamlToPhpConverter, \ConfigTransformer2021093010\Symplify\PhpConfigPrinter\Provider\CurrentFilePathProvider $currentFilePathProvider, \ConfigTransformer2021093010\Symplify\ConfigTransformer\Collector\XmlImportCollector $xmlImportCollector, \ConfigTransformer2021093010\Symplify\ConfigTransformer\DependencyInjection\ContainerBuilderCleaner $containerBuilderCleaner, \ConfigTransformer2021093010\Symplify\PackageBuilder\Reflection\PrivatesAccessor $privatesAccessor, \ConfigTransformer2021093010\Symplify\PackageBuilder\Yaml\ParametersMerger $parametersMerger)
    {
        $this->configLoader = $configLoader;
        $this->yamlToPhpConverter = $yamlToPhpConverter;
        $this->currentFilePathProvider = $currentFilePathProvider;
        $this->xmlImportCollector = $xmlImportCollector;
        $this->containerBuilderCleaner = $containerBuilderCleaner;
        $this->privatesAccessor = $privatesAccessor;
        $this->parametersMerger = $parametersMerger;
    }
    public function convert(\ConfigTransformer2021093010\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, \ConfigTransformer2021093010\Symplify\ConfigTransformer\ValueObject\Configuration $configuration) : string
    {
        $this->currentFilePathProvider->setFilePath($smartFileInfo->getRealPath());
        $containerBuilderAndFileContent = $this->configLoader->createAndLoadContainerBuilderFromFileInfo($smartFileInfo, $configuration);
        $containerBuilder = $containerBuilderAndFileContent->getContainerBuilder();
        if ($smartFileInfo->getSuffix() === \ConfigTransformer2021093010\Symplify\ConfigTransformer\ValueObject\Format::YAML) {
            $dumpedYaml = $containerBuilderAndFileContent->getFileContent();
            $dumpedYaml = $this->decorateWithCollectedXmlImports($dumpedYaml);
            return $this->yamlToPhpConverter->convert($dumpedYaml);
        }
        if ($smartFileInfo->getSuffix() === \ConfigTransformer2021093010\Symplify\ConfigTransformer\ValueObject\Format::XML) {
            $dumpedYaml = $this->dumpContainerBuilderToYaml($containerBuilder);
            $dumpedYaml = $this->decorateWithCollectedXmlImports($dumpedYaml);
            return $this->yamlToPhpConverter->convert($dumpedYaml);
        }
        $message = \sprintf('Suffix "%s" is not support yet', $smartFileInfo->getSuffix());
        throw new \ConfigTransformer2021093010\Symplify\PackageBuilder\Exception\NotImplementedYetException($message);
    }
    private function dumpContainerBuilderToYaml(\ConfigTransformer2021093010\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : string
    {
        $yamlDumper = new \ConfigTransformer2021093010\Symfony\Component\DependencyInjection\Dumper\YamlDumper($containerBuilder);
        $this->containerBuilderCleaner->cleanContainerBuilder($containerBuilder);
        // 1. services and parameters
        $content = $yamlDumper->dump();
        if (!\is_string($content)) {
            throw new \ConfigTransformer2021093010\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        // 2. append extension yaml too
        $extensionsConfigs = $this->privatesAccessor->getPrivateProperty($containerBuilder, 'extensionConfigs');
        foreach ($extensionsConfigs as $namespace => $configs) {
            $mergedConfig = [];
            foreach ($configs as $config) {
                $mergedConfig = $this->parametersMerger->merge($mergedConfig, $config);
            }
            $extensionsConfigs[$namespace] = $mergedConfig;
        }
        $extensionsContent = $this->dumpYaml($extensionsConfigs);
        return $content . \PHP_EOL . $extensionsContent;
    }
    private function decorateWithCollectedXmlImports(string $dumpedYaml) : string
    {
        $collectedXmlImports = $this->xmlImportCollector->provide();
        if ($collectedXmlImports === []) {
            return $dumpedYaml;
        }
        $yamlArray = \ConfigTransformer2021093010\Symfony\Component\Yaml\Yaml::parse($dumpedYaml, \ConfigTransformer2021093010\Symfony\Component\Yaml\Yaml::PARSE_CUSTOM_TAGS);
        $yamlArray['imports'] = \array_merge($yamlArray['imports'] ?? [], $collectedXmlImports);
        return $this->dumpYaml($yamlArray);
    }
    /**
     * @param array<string, mixed> $yamlArray
     */
    private function dumpYaml(array $yamlArray) : string
    {
        if ($yamlArray === []) {
            return '';
        }
        return \ConfigTransformer2021093010\Symfony\Component\Yaml\Yaml::dump($yamlArray, 10, 4, \ConfigTransformer2021093010\Symfony\Component\Yaml\Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);
    }
}
