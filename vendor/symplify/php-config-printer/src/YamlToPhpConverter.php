<?php

declare (strict_types=1);
namespace ConfigTransformer202109202\Symplify\PhpConfigPrinter;

use ConfigTransformer202109202\Symfony\Component\Yaml\Parser;
use ConfigTransformer202109202\Symfony\Component\Yaml\Yaml;
use ConfigTransformer202109202\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
use ConfigTransformer202109202\Symplify\PhpConfigPrinter\NodeFactory\ContainerConfiguratorReturnClosureFactory;
use ConfigTransformer202109202\Symplify\PhpConfigPrinter\NodeFactory\RoutingConfiguratorReturnClosureFactory;
use ConfigTransformer202109202\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter;
use ConfigTransformer202109202\Symplify\PhpConfigPrinter\Yaml\CheckerServiceParametersShifter;
/**
 * @source https://raw.githubusercontent.com/archeoprog/maker-bundle/make-convert-services/src/Util/PhpServicesCreator.php
 * @see \Symplify\PhpConfigPrinter\Tests\YamlToPhpConverter\YamlToPhpConverterTest
 */
final class YamlToPhpConverter
{
    /**
     * @var string[]
     */
    private const ROUTING_KEYS = ['resource', 'prefix', 'path', 'controller'];
    /**
     * @var \Symfony\Component\Yaml\Parser
     */
    private $parser;
    /**
     * @var \Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter
     */
    private $phpParserPhpConfigPrinter;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ContainerConfiguratorReturnClosureFactory
     */
    private $containerConfiguratorReturnClosureFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\RoutingConfiguratorReturnClosureFactory
     */
    private $routingConfiguratorReturnClosureFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface
     */
    private $yamlFileContentProvider;
    /**
     * @var \Symplify\PhpConfigPrinter\Yaml\CheckerServiceParametersShifter
     */
    private $checkerServiceParametersShifter;
    public function __construct(\ConfigTransformer202109202\Symfony\Component\Yaml\Parser $parser, \ConfigTransformer202109202\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter $phpParserPhpConfigPrinter, \ConfigTransformer202109202\Symplify\PhpConfigPrinter\NodeFactory\ContainerConfiguratorReturnClosureFactory $containerConfiguratorReturnClosureFactory, \ConfigTransformer202109202\Symplify\PhpConfigPrinter\NodeFactory\RoutingConfiguratorReturnClosureFactory $routingConfiguratorReturnClosureFactory, \ConfigTransformer202109202\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface $yamlFileContentProvider, \ConfigTransformer202109202\Symplify\PhpConfigPrinter\Yaml\CheckerServiceParametersShifter $checkerServiceParametersShifter)
    {
        $this->parser = $parser;
        $this->phpParserPhpConfigPrinter = $phpParserPhpConfigPrinter;
        $this->containerConfiguratorReturnClosureFactory = $containerConfiguratorReturnClosureFactory;
        $this->routingConfiguratorReturnClosureFactory = $routingConfiguratorReturnClosureFactory;
        $this->yamlFileContentProvider = $yamlFileContentProvider;
        $this->checkerServiceParametersShifter = $checkerServiceParametersShifter;
    }
    public function convert(string $yaml) : string
    {
        $this->yamlFileContentProvider->setContent($yaml);
        /** @var mixed[]|null $yamlArray */
        $yamlArray = $this->parser->parse($yaml, \ConfigTransformer202109202\Symfony\Component\Yaml\Yaml::PARSE_CUSTOM_TAGS | \ConfigTransformer202109202\Symfony\Component\Yaml\Yaml::PARSE_CONSTANT);
        if ($yamlArray === null) {
            return '';
        }
        return $this->convertYamlArray($yamlArray);
    }
    public function convertYamlArray(array $yamlArray) : string
    {
        if ($this->isRouteYaml($yamlArray)) {
            $return = $this->routingConfiguratorReturnClosureFactory->createFromArrayData($yamlArray);
        } else {
            $yamlArray = $this->checkerServiceParametersShifter->process($yamlArray);
            $return = $this->containerConfiguratorReturnClosureFactory->createFromYamlArray($yamlArray);
        }
        return $this->phpParserPhpConfigPrinter->prettyPrintFile([$return]);
    }
    /**
     * @param array<string, mixed> $yaml
     */
    private function isRouteYaml(array $yaml) : bool
    {
        foreach ($yaml as $value) {
            foreach (self::ROUTING_KEYS as $routeKey) {
                if (isset($value[$routeKey])) {
                    return \true;
                }
            }
        }
        return \false;
    }
}
