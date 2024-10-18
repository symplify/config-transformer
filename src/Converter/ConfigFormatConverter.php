<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Converter;

use Symfony\Component\Finder\SplFileInfo;
use Symplify\ConfigTransformer\ConfigLoader;
use Symplify\ConfigTransformer\Enum\Format;
use Symplify\ConfigTransformer\Exception\NotImplementedYetException;
use Symplify\PhpConfigPrinter\Provider\CurrentFilePathProvider;

final class ConfigFormatConverter
{
    public function __construct(
        private readonly ConfigLoader $configLoader,
        private readonly YamlToPhpConverter $yamlToPhpConverter,
        private readonly CurrentFilePathProvider $currentFilePathProvider,
    ) {
    }

    public function convert(SplFileInfo $fileInfo): string
    {
        $this->currentFilePathProvider->setFilePath($fileInfo->getRealPath());

        $dumpedContainerContent = $this->configLoader->createAndLoadContainerBuilderFromFileInfo(
            $fileInfo
        );

        if (in_array($fileInfo->getExtension(), [Format::YAML, Format::YML], true)) {
            return $this->yamlToPhpConverter->convert($dumpedContainerContent, $fileInfo->getRealPath());
        }

        $message = sprintf('Suffix "%s" is not support yet', $fileInfo->getExtension());
        throw new NotImplementedYetException($message);
    }
}
