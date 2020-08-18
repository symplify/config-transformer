<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter;

use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ContainerConfiguratorReturnClosureFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\RoutingConfiguratorReturnClosureFactory;
use Migrify\ConfigTransformer\FormatSwitcher\Provider\YamlContentProvider;
use Migrify\ConfigTransformer\FormatSwitcher\Yaml\CheckerServiceParametersShifter;
use Migrify\PhpConfigPrinter\Printer\PhpConfigurationPrinter;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Yaml;

/**
 * @source https://raw.githubusercontent.com/archeoprog/maker-bundle/make-convert-services/src/Util/PhpServicesCreator.php
 *
 * @see \Migrify\ConfigTransformer\FormatSwitcher\Tests\Converter\ConfigFormatConverter\YamlToPhpTest
 */
final class YamlToPhpConverter
{
    /**
     * @var string[]
     */
    private const ROUTING_KEYS = ['resource', 'prefix', 'path', 'controller'];

    /**
     * @var Parser
     */
    private $yamlParser;

    /**
     * @var PhpConfigurationPrinter
     */
    private $phpConfigurationPrinter;

    /**
     * @var ContainerConfiguratorReturnClosureFactory
     */
    private $containerConfiguratorReturnClosureFactory;

    /**
     * @var YamlContentProvider
     */
    private $yamlContentProvider;

    /**
     * @var CheckerServiceParametersShifter
     */
    private $checkerServiceParametersShifter;

    /**
     * @var RoutingConfiguratorReturnClosureFactory
     */
    private $routingConfiguratorReturnClosureFactory;

    public function __construct(
        Parser $yamlParser,
        PhpConfigurationPrinter $phpConfigurationPrinter,
        ContainerConfiguratorReturnClosureFactory $returnClosureNodesFactory,
        RoutingConfiguratorReturnClosureFactory $routingConfiguratorReturnClosureFactory,
        YamlContentProvider $yamlContentProvider,
        CheckerServiceParametersShifter $checkerServiceParametersShifter
    ) {
        $this->yamlParser = $yamlParser;
        $this->phpConfigurationPrinter = $phpConfigurationPrinter;
        $this->containerConfiguratorReturnClosureFactory = $returnClosureNodesFactory;
        $this->yamlContentProvider = $yamlContentProvider;
        $this->checkerServiceParametersShifter = $checkerServiceParametersShifter;
        $this->routingConfiguratorReturnClosureFactory = $routingConfiguratorReturnClosureFactory;
    }

    public function convert(string $yaml): string
    {
        $this->yamlContentProvider->setContent($yaml);

        /** @var mixed[]|null $yamlArray */
        $yamlArray = $this->yamlParser->parse($yaml, Yaml::PARSE_CUSTOM_TAGS | Yaml::PARSE_CONSTANT);
        if ($yamlArray === null) {
            return '';
        }

        if ($this->isRouteYaml($yamlArray)) {
            $return = $this->routingConfiguratorReturnClosureFactory->createFromYamlArray($yamlArray);
        } else {
            $yamlArray = $this->checkerServiceParametersShifter->process($yamlArray);
            $return = $this->containerConfiguratorReturnClosureFactory->createFromYamlArray($yamlArray);
        }

        return $this->phpConfigurationPrinter->prettyPrintFile([$return]);
    }

    private function isRouteYaml(array $yaml): bool
    {
        foreach ($yaml as $value) {
            foreach (self::ROUTING_KEYS as $routeKey) {
                if (isset($value[$routeKey])) {
                    return true;
                }
            }
        }

        return false;
    }
}
