<?php

declare (strict_types=1);
namespace ConfigTransformer202201309\Symplify\ConfigTransformer\Converter;

use ConfigTransformer202201309\Symfony\Component\Yaml\Parser;
use ConfigTransformer202201309\Symfony\Component\Yaml\Yaml;
use ConfigTransformer202201309\Symplify\PhpConfigPrinter\Dummy\YamlContentProvider;
use ConfigTransformer202201309\Symplify\PhpConfigPrinter\NodeFactory\ContainerConfiguratorReturnClosureFactory;
use ConfigTransformer202201309\Symplify\PhpConfigPrinter\NodeFactory\RoutingConfiguratorReturnClosureFactory;
use ConfigTransformer202201309\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter;
use ConfigTransformer202201309\Symplify\PhpConfigPrinter\Yaml\CheckerServiceParametersShifter;
/**
 * @api
 * @source https://raw.githubusercontent.com/archeoprog/maker-bundle/make-convert-services/src/Util/PhpServicesCreator.php
 *
 * @see \Symplify\ConfigTransformer\Tests\Converter\YamlToPhpConverter\YamlToPhpConverterTest
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
     * @var \Symplify\PhpConfigPrinter\Dummy\YamlContentProvider
     */
    private $yamlContentProvider;
    /**
     * @var \Symplify\PhpConfigPrinter\Yaml\CheckerServiceParametersShifter
     */
    private $checkerServiceParametersShifter;
    public function __construct(\ConfigTransformer202201309\Symfony\Component\Yaml\Parser $parser, \ConfigTransformer202201309\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter $phpParserPhpConfigPrinter, \ConfigTransformer202201309\Symplify\PhpConfigPrinter\NodeFactory\ContainerConfiguratorReturnClosureFactory $containerConfiguratorReturnClosureFactory, \ConfigTransformer202201309\Symplify\PhpConfigPrinter\NodeFactory\RoutingConfiguratorReturnClosureFactory $routingConfiguratorReturnClosureFactory, \ConfigTransformer202201309\Symplify\PhpConfigPrinter\Dummy\YamlContentProvider $yamlContentProvider, \ConfigTransformer202201309\Symplify\PhpConfigPrinter\Yaml\CheckerServiceParametersShifter $checkerServiceParametersShifter)
    {
        $this->parser = $parser;
        $this->phpParserPhpConfigPrinter = $phpParserPhpConfigPrinter;
        $this->containerConfiguratorReturnClosureFactory = $containerConfiguratorReturnClosureFactory;
        $this->routingConfiguratorReturnClosureFactory = $routingConfiguratorReturnClosureFactory;
        $this->yamlContentProvider = $yamlContentProvider;
        $this->checkerServiceParametersShifter = $checkerServiceParametersShifter;
    }
    public function convert(string $yaml) : string
    {
        $this->yamlContentProvider->setContent($yaml);
        /** @var mixed[]|null $yamlArray */
        $yamlArray = $this->parser->parse($yaml, \ConfigTransformer202201309\Symfony\Component\Yaml\Yaml::PARSE_CUSTOM_TAGS | \ConfigTransformer202201309\Symfony\Component\Yaml\Yaml::PARSE_CONSTANT);
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
     * @param array<string, mixed> $yamlLines
     */
    private function isRouteYaml(array $yamlLines) : bool
    {
        foreach ($yamlLines as $yamlLine) {
            foreach (self::ROUTING_KEYS as $routeKey) {
                if (isset($yamlLine[$routeKey])) {
                    return \true;
                }
            }
        }
        return \false;
    }
}
