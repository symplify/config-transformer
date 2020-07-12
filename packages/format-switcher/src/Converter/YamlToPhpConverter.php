<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter;

use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\FluentClosureNamespaceNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\Printer\FluentPhpConfigurationPrinter;
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
     * @var FluentPhpConfigurationPrinter
     */
    private $fluentPhpConfigurationPrinter;

    /**
     * @var FluentClosureNamespaceNodeFactory
     */
    private $fluentClosureNamespaceNodeFactory;

    public function __construct(
        Parser $yamlParser,
        FluentPhpConfigurationPrinter $fluentPhpConfigurationPrinter,
        FluentClosureNamespaceNodeFactory $fluentClosureNamespaceNodeFactory
    ) {
        $this->yamlParser = $yamlParser;
        $this->fluentPhpConfigurationPrinter = $fluentPhpConfigurationPrinter;
        $this->fluentClosureNamespaceNodeFactory = $fluentClosureNamespaceNodeFactory;
    }

    public function convert(string $yaml): string
    {
        $yamlArray = $this->yamlParser->parse($yaml, Yaml::PARSE_CUSTOM_TAGS);
        $namespace = $this->fluentClosureNamespaceNodeFactory->createFromYamlArray($yamlArray);

        return $this->fluentPhpConfigurationPrinter->prettyPrintFile([$namespace]);
    }
}
