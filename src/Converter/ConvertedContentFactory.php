<?php

declare (strict_types=1);
namespace ConfigTransformer202109220\Symplify\ConfigTransformer\Converter;

use ConfigTransformer202109220\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformer202109220\Symplify\ConfigTransformer\ValueObject\Configuration;
use ConfigTransformer202109220\Symplify\ConfigTransformer\ValueObject\ConvertedContent;
use ConfigTransformer202109220\Symplify\SmartFileSystem\SmartFileInfo;
final class ConvertedContentFactory
{
    /**
     * @var \Symfony\Component\Console\Style\SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var \Symplify\ConfigTransformer\Converter\ConfigFormatConverter
     */
    private $configFormatConverter;
    public function __construct(\ConfigTransformer202109220\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \ConfigTransformer202109220\Symplify\ConfigTransformer\Converter\ConfigFormatConverter $configFormatConverter)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->configFormatConverter = $configFormatConverter;
    }
    /**
     * @param SmartFileInfo[] $fileInfos
     * @return ConvertedContent[]
     */
    public function createFromFileInfos(array $fileInfos, \ConfigTransformer202109220\Symplify\ConfigTransformer\ValueObject\Configuration $configuration) : array
    {
        $convertedContentFromFileInfo = [];
        foreach ($fileInfos as $fileInfo) {
            $message = \sprintf('Processing "%s" file', $fileInfo->getRelativeFilePathFromCwd());
            $this->symfonyStyle->note($message);
            $convertedContent = $this->configFormatConverter->convert($fileInfo, $configuration);
            $convertedContentFromFileInfo[] = new \ConfigTransformer202109220\Symplify\ConfigTransformer\ValueObject\ConvertedContent($convertedContent, $fileInfo);
        }
        return $convertedContentFromFileInfo;
    }
}
