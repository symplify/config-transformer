<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Converter;

use ConfigTransformerPrefix202302\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformerPrefix202302\Symfony\Component\DependencyInjection\Dumper\YamlDumper;
use ConfigTransformerPrefix202302\Symfony\Component\Yaml\Yaml;
use Symplify\ConfigTransformer\Collector\XmlImportCollector;
use Symplify\ConfigTransformer\ConfigLoader;
use Symplify\ConfigTransformer\DependencyInjection\ContainerBuilderCleaner;
use Symplify\ConfigTransformer\Enum\Format;
use Symplify\ConfigTransformer\Exception\NotImplementedYetException;
use ConfigTransformerPrefix202302\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use ConfigTransformerPrefix202302\Symplify\PackageBuilder\Yaml\ParametersMerger;
use Symplify\PhpConfigPrinter\Provider\CurrentFilePathProvider;
use ConfigTransformerPrefix202302\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformerPrefix202302\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class ConfigFormatConverter
{
    /**
     * @var \Symplify\ConfigTransformer\ConfigLoader
     */
    private $configLoader;
    /**
     * @var \Symplify\ConfigTransformer\Converter\YamlToPhpConverter
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
    public function __construct(ConfigLoader $configLoader, \Symplify\ConfigTransformer\Converter\YamlToPhpConverter $yamlToPhpConverter, CurrentFilePathProvider $currentFilePathProvider, XmlImportCollector $xmlImportCollector, ContainerBuilderCleaner $containerBuilderCleaner, PrivatesAccessor $privatesAccessor, ParametersMerger $parametersMerger)
    {
        $this->configLoader = $configLoader;
        $this->yamlToPhpConverter = $yamlToPhpConverter;
        $this->currentFilePathProvider = $currentFilePathProvider;
        $this->xmlImportCollector = $xmlImportCollector;
        $this->containerBuilderCleaner = $containerBuilderCleaner;
        $this->privatesAccessor = $privatesAccessor;
        $this->parametersMerger = $parametersMerger;
    }
    public function convert(SmartFileInfo $smartFileInfo) : string
    {
        $this->currentFilePathProvider->setFilePath($smartFileInfo->getRealPath());
        $containerBuilderAndFileContent = $this->configLoader->createAndLoadContainerBuilderFromFileInfo($smartFileInfo);
        $containerBuilder = $containerBuilderAndFileContent->getContainerBuilder();
        if (\in_array($smartFileInfo->getSuffix(), [Format::YAML, Format::YML], \true)) {
            $dumpedYaml = $containerBuilderAndFileContent->getFileContent();
            $dumpedYaml = $this->decorateWithCollectedXmlImports($dumpedYaml);
            return $this->yamlToPhpConverter->convert($dumpedYaml, $smartFileInfo->getRealPath());
        }
        if ($smartFileInfo->getSuffix() === Format::XML) {
            $dumpedYaml = $this->dumpContainerBuilderToYaml($containerBuilder);
            $dumpedYaml = $this->decorateWithCollectedXmlImports($dumpedYaml);
            return $this->yamlToPhpConverter->convert($dumpedYaml, $smartFileInfo->getRealPath());
        }
        $message = \sprintf('Suffix "%s" is not support yet', $smartFileInfo->getSuffix());
        throw new NotImplementedYetException($message);
    }
    private function dumpContainerBuilderToYaml(ContainerBuilder $containerBuilder) : string
    {
        $yamlDumper = new YamlDumper($containerBuilder);
        $this->containerBuilderCleaner->cleanContainerBuilder($containerBuilder);
        // 1. services and parameters
        $content = $yamlDumper->dump();
        if (!\is_string($content)) {
            throw new ShouldNotHappenException();
        }
        // 2. append extension yaml too
        /** @var array<string, string[]> $extensionsConfigs */
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
        /** @var array<string, mixed> $yamlArray */
        $yamlArray = Yaml::parse($dumpedYaml, Yaml::PARSE_CUSTOM_TAGS);
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
        return Yaml::dump($yamlArray, 10, 4, Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);
    }
}
