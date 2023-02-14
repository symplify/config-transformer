<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Converter;

use ConfigTransformerPrefix202302\Symfony\Component\Yaml\Parser;
use ConfigTransformerPrefix202302\Symfony\Component\Yaml\Yaml;
use Symplify\ConfigTransformer\Routing\RoutingConfigDetector;
use Symplify\PhpConfigPrinter\NodeFactory\ContainerConfiguratorReturnClosureFactory;
use Symplify\PhpConfigPrinter\NodeFactory\RoutingConfiguratorReturnClosureFactory;
use Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter;
use Symplify\PhpConfigPrinter\Yaml\CheckerServiceParametersShifter;
/**
 * @api
 * @source https://raw.githubusercontent.com/archeoprog/maker-bundle/make-convert-services/src/Util/PhpServicesCreator.php
 *
 * @see \Symplify\ConfigTransformer\Tests\Converter\YamlToPhpConverter\YamlToPhpConverterTest
 */
final class YamlToPhpConverter
{
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
     * @var \Symplify\PhpConfigPrinter\Yaml\CheckerServiceParametersShifter
     */
    private $checkerServiceParametersShifter;
    /**
     * @var \Symplify\ConfigTransformer\Routing\RoutingConfigDetector
     */
    private $routingConfigDetector;
    public function __construct(Parser $parser, PhpParserPhpConfigPrinter $phpParserPhpConfigPrinter, ContainerConfiguratorReturnClosureFactory $containerConfiguratorReturnClosureFactory, RoutingConfiguratorReturnClosureFactory $routingConfiguratorReturnClosureFactory, CheckerServiceParametersShifter $checkerServiceParametersShifter, RoutingConfigDetector $routingConfigDetector)
    {
        $this->parser = $parser;
        $this->phpParserPhpConfigPrinter = $phpParserPhpConfigPrinter;
        $this->containerConfiguratorReturnClosureFactory = $containerConfiguratorReturnClosureFactory;
        $this->routingConfiguratorReturnClosureFactory = $routingConfiguratorReturnClosureFactory;
        $this->checkerServiceParametersShifter = $checkerServiceParametersShifter;
        $this->routingConfigDetector = $routingConfigDetector;
    }
    public function convert(string $yaml, string $filePath) : string
    {
        /** @var mixed[]|null $yamlArray */
        $yamlArray = $this->parser->parse($yaml, Yaml::PARSE_CUSTOM_TAGS | Yaml::PARSE_CONSTANT);
        if ($yamlArray === null) {
            return '';
        }
        return $this->convertYamlArray($yamlArray, $filePath);
    }
    /**
     * @param array<string, mixed> $yamlArray
     */
    public function convertYamlArray(array $yamlArray, string $filePath) : string
    {
        if ($this->routingConfigDetector->isRoutingFilePath($filePath)) {
            $return = $this->routingConfiguratorReturnClosureFactory->createFromArrayData($yamlArray);
        } else {
            $yamlArray = $this->checkerServiceParametersShifter->process($yamlArray);
            $return = $this->containerConfiguratorReturnClosureFactory->createFromYamlArray($yamlArray);
        }
        return $this->phpParserPhpConfigPrinter->prettyPrintFile([$return]);
    }
}
