<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\ValueObject;

use ConfigTransformerPrefix202302\Nette\Utils\Strings;
use ConfigTransformerPrefix202302\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(string $convertedContent, SmartFileInfo $originalFileInfo)
    {
        $this->convertedContent = $convertedContent;
        $this->originalFileInfo = $originalFileInfo;
    }
    public function getConvertedContent() : string
    {
        return $this->convertedContent;
    }
    public function getNewRelativeFilePath() : string
    {
        $originalRelativeFilePath = $this->getOriginalRelativeFilePath();
        $relativeFilePathWithoutSuffix = Strings::before($originalRelativeFilePath, '.', -1);
        return $relativeFilePathWithoutSuffix . '.php';
    }
    public function getOriginalFilePathWithoutSuffix() : string
    {
        return $this->originalFileInfo->getRealPathWithoutSuffix();
    }
    public function getOriginalRelativeFilePath() : string
    {
        return $this->originalFileInfo->getRelativeFilePathFromCwd();
    }
    public function getOriginalContent() : string
    {
        return $this->originalFileInfo->getContents();
    }
}
