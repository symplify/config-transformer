<?php

declare (strict_types=1);
namespace ConfigTransformer202206069\Symplify\ConfigTransformer\ValueObject;

use ConfigTransformer202206069\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(string $convertedContent, \ConfigTransformer202206069\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo)
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
