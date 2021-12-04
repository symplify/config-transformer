<?php

declare (strict_types=1);
namespace ConfigTransformer2021120410\Symplify\ConfigTransformer\ValueObject;

use ConfigTransformer2021120410\Symplify\SmartFileSystem\SmartFileInfo;
final class ConvertedContent
{
    /**
     * @var string
     */
    private $convertedContent;
    /**
     * @var \Symplify\SmartFileSystem\SmartFileInfo
     */
    private $originalFileInfo;
    public function __construct(string $convertedContent, \ConfigTransformer2021120410\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo)
    {
        $this->convertedContent = $convertedContent;
        $this->originalFileInfo = $originalFileInfo;
    }
    public function getConvertedContent() : string
    {
        return $this->convertedContent;
    }
    public function getOriginalFilePathWithoutSuffix() : string
    {
        return $this->originalFileInfo->getRealPathWithoutSuffix();
    }
}
