<?php

declare (strict_types=1);
namespace ConfigTransformer202109309\Symplify\ConfigTransformer\Converter;

use ConfigTransformer202109309\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202109309\Symfony\Component\DependencyInjection\Dumper\YamlDumper;
use ConfigTransformer202109309\Symfony\Component\Yaml\Yaml;
use ConfigTransformer202109309\Symplify\ConfigTransformer\Collector\XmlImportCollector;
use ConfigTransformer202109309\Symplify\ConfigTransformer\ConfigLoader;
use ConfigTransformer202109309\Symplify\ConfigTransformer\DependencyInjection\ContainerBuilderCleaner;
use ConfigTransformer202109309\Symplify\ConfigTransformer\ValueObject\Configuration;
use ConfigTransformer202109309\Symplify\ConfigTransformer\ValueObject\Format;
use ConfigTransformer202109309\Symplify\PackageBuilder\Exception\NotImplementedYetException;
use ConfigTransformer202109309\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use ConfigTransformer202109309\Symplify\PackageBuilder\Yaml\ParametersMerger;
use ConfigTransformer202109309\Symplify\PhpConfigPrinter\Provider\CurrentFilePathProvider;
use ConfigTransformer202109309\Symplify\PhpConfigPrinter\YamlToPhpConverter;
use ConfigTransformer202109309\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer202109309\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
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
    public function __construct(\ConfigTransformer202109309\Symplify\ConfigTransformer\ConfigLoader $configLoader, \ConfigTransformer202109309\Symplify\PhpConfigPrinter\YamlToPhpConverter $yamlToPhpConverter, \ConfigTransformer202109309\Symplify\PhpConfigPrinter\Provider\CurrentFilePathProvider $currentFilePathProvider, \ConfigTransformer202109309\Symplify\ConfigTransformer\Collector\XmlImportCollector $xmlImportCollector, \ConfigTransformer202109309\Symplify\ConfigTransformer\DependencyInjection\ContainerBuilderCleaner $containerBuilderCleaner, \ConfigTransformer202109309\Symplify\PackageBuilder\Reflection\PrivatesAccessor $privatesAccessor, \ConfigTransformer202109309\Symplify\PackageBuilder\Yaml\ParametersMerger $parametersMerger)
    {
        $this->configLoader = $configLoader;
        $this->yamlToPhpConverter = $yamlToPhpConverter;
        $this->currentFilePathProvider = $currentFilePathProvider;
        $this->xmlImportCollector = $xmlImportCollector;
        $this->containerBuilderCleaner = $containerBuilderCleaner;
        $this->privatesAccessor = $privatesAccessor;
        $this->parametersMerger = $parametersMerger;
    }
    public function convert(\ConfigTransformer202109309\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, \ConfigTransformer202109309\Symplify\ConfigTransformer\ValueObject\Configuration $configuration) : string
    {
        $this->currentFilePathProvider->setFilePath($smartFileInfo->getRealPath());
        $containerBuilderAndFileContent = $this->configLoader->createAndLoadContainerBuilderFromFileInfo($smartFileInfo, $configuration);
        $containerBuilder = $containerBuilderAndFileContent->getContainerBuilder();
        if ($smartFileInfo->getSuffix() === \ConfigTransformer202109309\Symplify\ConfigTransformer\ValueObject\Format::YAML) {
            $dumpedYaml = $containerBuilderAndFileContent->getFileContent();
            $dumpedYaml = $this->decorateWithCollectedXmlImports($dumpedYaml);
            return $this->yamlToPhpConverter->convert($dumpedYaml);
        }
        if ($smartFileInfo->getSuffix() === \ConfigTransformer202109309\Symplify\ConfigTransformer\ValueObject\Format::XML) {
            $dumpedYaml = $this->dumpContainerBuilderToYaml($containerBuilder);
            $dumpedYaml = $this->decorateWithCollectedXmlImports($dumpedYaml);
            return $this->yamlToPhpConverter->convert($dumpedYaml);
        }
        $message = \sprintf('Suffix "%s" is not support yet', $smartFileInfo->getSuffix());
        throw new \ConfigTransformer202109309\Symplify\PackageBuilder\Exception\NotImplementedYetException($message);
    }
    private function dumpContainerBuilderToYaml(\ConfigTransformer202109309\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : string
    {
        $yamlDumper = new \ConfigTransformer202109309\Symfony\Component\DependencyInjection\Dumper\YamlDumper($containerBuilder);
        $this->containerBuilderCleaner->cleanContainerBuilder($containerBuilder);
        // 1. services and parameters
        $content = $yamlDumper->dump();
        if (!\is_string($content)) {
            throw new \ConfigTransformer202109309\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
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
        $yamlArray = \ConfigTransformer202109309\Symfony\Component\Yaml\Yaml::parse($dumpedYaml, \ConfigTransformer202109309\Symfony\Component\Yaml\Yaml::PARSE_CUSTOM_TAGS);
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
        return \ConfigTransformer202109309\Symfony\Component\Yaml\Yaml::dump($yamlArray, 10, 4, \ConfigTransformer202109309\Symfony\Component\Yaml\Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);
    }
}
