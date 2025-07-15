<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Converter;

use ConfigTransformerPrefix202507\Symfony\Component\Finder\SplFileInfo;
use Symplify\ConfigTransformer\ConfigLoader;
use Symplify\ConfigTransformer\Enum\Format;
use Symplify\ConfigTransformer\Exception\NotImplementedYetException;
use Symplify\PhpConfigPrinter\Provider\CurrentFilePathProvider;
final class ConfigFormatConverter
{
    /**
     * @readonly
     * @var \Symplify\ConfigTransformer\ConfigLoader
     */
    private $configLoader;
    /**
     * @readonly
     * @var \Symplify\ConfigTransformer\Converter\YamlToPhpConverter
     */
    private $yamlToPhpConverter;
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\Provider\CurrentFilePathProvider
     */
    private $currentFilePathProvider;
    public function __construct(ConfigLoader $configLoader, \Symplify\ConfigTransformer\Converter\YamlToPhpConverter $yamlToPhpConverter, CurrentFilePathProvider $currentFilePathProvider)
    {
        $this->configLoader = $configLoader;
        $this->yamlToPhpConverter = $yamlToPhpConverter;
        $this->currentFilePathProvider = $currentFilePathProvider;
    }
    public function convert(SplFileInfo $fileInfo) : string
    {
        $this->currentFilePathProvider->setFilePath($fileInfo->getRealPath());
        $dumpedContainerContent = $this->configLoader->createAndLoadContainerBuilderFromFileInfo($fileInfo);
        if (\in_array($fileInfo->getExtension(), [Format::YAML, Format::YML], \true)) {
            return $this->yamlToPhpConverter->convert($dumpedContainerContent, $fileInfo->getRealPath());
        }
        $message = \sprintf('Suffix "%s" is not supported', $fileInfo->getExtension());
        throw new NotImplementedYetException($message);
    }
}
