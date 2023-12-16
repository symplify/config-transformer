<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\ValueObject;

use ConfigTransformerPrefix202312\Nette\Utils\Strings;
use ConfigTransformerPrefix202312\Symfony\Component\Finder\SplFileInfo;
use Symplify\ConfigTransformer\FileSystem\RelativeFilePathHelper;
final class ConvertedContent
{
    /**
     * @readonly
     * @var string
     */
    private $convertedContent;
    /**
     * @readonly
     * @var \Symfony\Component\Finder\SplFileInfo
     */
    private $originalFileInfo;
    /**
     * @var string
     * @see https://regex101.com/r/SYP00O/1
     */
    private const LAST_SUFFIX_REGEX = '#\\.[^.]+$#';
    public function __construct(string $convertedContent, SplFileInfo $originalFileInfo)
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
        return Strings::replace($this->originalFileInfo->getRealPath(), self::LAST_SUFFIX_REGEX, '');
    }
    public function getOriginalRelativeFilePath() : string
    {
        return RelativeFilePathHelper::resolveFromDirectory($this->originalFileInfo->getRealPath(), \getcwd());
    }
    public function getOriginalContent() : string
    {
        return $this->originalFileInfo->getContents();
    }
}
