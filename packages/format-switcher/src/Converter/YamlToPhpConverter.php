<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter;

use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ContainerConfiguratorReturnClosureFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\Printer\PhpConfigurationPrinter;
use Migrify\ConfigTransformer\FormatSwitcher\Provider\YamlContentProvider;
use Migrify\ConfigTransformer\FormatSwitcher\Yaml\CheckerServiceParametersShifter;
use Nette\Utils\Strings;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Yaml;
use Symplify\SmartFileSystem\SmartFileInfo;

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

    public function __construct(
        Parser $yamlParser,
        PhpConfigurationPrinter $phpConfigurationPrinter,
        ContainerConfiguratorReturnClosureFactory $returnClosureNodesFactory,
        YamlContentProvider $yamlContentProvider,
        CheckerServiceParametersShifter $checkerServiceParametersShifter
    ) {
        $this->yamlParser = $yamlParser;
        $this->phpConfigurationPrinter = $phpConfigurationPrinter;
        $this->containerConfiguratorReturnClosureFactory = $returnClosureNodesFactory;
        $this->yamlContentProvider = $yamlContentProvider;
        $this->checkerServiceParametersShifter = $checkerServiceParametersShifter;
    }

    public function convert(string $yaml, SmartFileInfo $smartFileInfo): string
    {
        $this->yamlContentProvider->setContent($yaml);

        /** @var mixed[]|null $yamlArray */
        $yamlArray = $this->yamlParser->parse($yaml, Yaml::PARSE_CUSTOM_TAGS | Yaml::PARSE_CONSTANT);
        if ($yamlArray === null) {
            return '';
        }

        if (Strings::match($smartFileInfo->getRealPath(), '#routes\.(yml|yaml)#')) {
            dump('ROUTEs');
            die;
        }
        $yamlArray = $this->checkerServiceParametersShifter->process($yamlArray);
        $return = $this->containerConfiguratorReturnClosureFactory->createFromYamlArray($yamlArray);

        return $this->phpConfigurationPrinter->prettyPrintFile([$return]);
    }
}
