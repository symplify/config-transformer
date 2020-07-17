<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter;

use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ReturnClosureNodesFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\Printer\PhpConfigurationPrinter;
use Migrify\ConfigTransformer\FormatSwitcher\Provider\YamlContentProvider;
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
     * @var Parser
     */
    private $yamlParser;

    /**
     * @var PhpConfigurationPrinter
     */
    private $phpConfigurationPrinter;

    /**
     * @var ReturnClosureNodesFactory
     */
    private $returnClosureNodesFactory;

    /**
     * @var YamlContentProvider
     */
    private $yamlContentProvider;

    public function __construct(
        Parser $yamlParser,
        PhpConfigurationPrinter $phpConfigurationPrinter,
        ReturnClosureNodesFactory $returnClosureNodesFactory,
        YamlContentProvider $yamlContentProvider
    ) {
        $this->yamlParser = $yamlParser;
        $this->phpConfigurationPrinter = $phpConfigurationPrinter;
        $this->returnClosureNodesFactory = $returnClosureNodesFactory;
        $this->yamlContentProvider = $yamlContentProvider;
    }

    public function convert(string $yaml): string
    {
        $this->yamlContentProvider->setContent($yaml);

        $yamlArray = $this->yamlParser->parse($yaml, Yaml::PARSE_CUSTOM_TAGS | Yaml::PARSE_CONSTANT);
        $nodes = $this->returnClosureNodesFactory->createFromYamlArray($yamlArray);

        return $this->phpConfigurationPrinter->prettyPrintFile($nodes);
    }
}
