<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Converter;

use Symplify\ConfigTransformer\ValueObject\ConvertedContent;
use ConfigTransformer202207\Symplify\SmartFileSystem\SmartFileInfo;
final class ConvertedContentFactory
{
    /**
     * @var \Symplify\ConfigTransformer\Converter\ConfigFormatConverter
     */
    private $configFormatConverter;
    public function __construct(\Symplify\ConfigTransformer\Converter\ConfigFormatConverter $configFormatConverter)
    {
        $this->configFormatConverter = $configFormatConverter;
    }
    public function createFromFileInfo(SmartFileInfo $fileInfo) : ConvertedContent
    {
        $convertedContent = $this->configFormatConverter->convert($fileInfo);
        return new ConvertedContent($convertedContent, $fileInfo);
    }
}
