<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\ValueObject;

use Entropy\Utils\Regex;
use Symfony\Component\Finder\SplFileInfo;
use Symplify\ConfigTransformer\FileSystem\RelativeFilePathHelper;

final class ConvertedContent
{
    /**
     * @var string
     * @see https://regex101.com/r/SYP00O/1
     */
    private const LAST_SUFFIX_REGEX = '#\.[^.]+$#';

    public function __construct(
        private readonly string $convertedContent,
        private readonly SplFileInfo $originalFileInfo
    ) {
    }

    public function getConvertedContent(): string
    {
        return $this->convertedContent;
    }

    public function getNewRelativeFilePath(): string
    {
        $originalRelativeFilePath = $this->getOriginalRelativeFilePath();
        $lastDotPosition = strrpos($originalRelativeFilePath, '.');
        $relativeFilePathWithoutSuffix = $lastDotPosition === false
            ? $originalRelativeFilePath
            : substr($originalRelativeFilePath, 0, $lastDotPosition);

        return $relativeFilePathWithoutSuffix . '.php';
    }

    public function getOriginalFilePathWithoutSuffix(): string
    {
        return Regex::replace($this->originalFileInfo->getRealPath(), self::LAST_SUFFIX_REGEX, '');
    }

    public function getOriginalRelativeFilePath(): string
    {
        return RelativeFilePathHelper::resolveFromDirectory($this->originalFileInfo->getRealPath(), getcwd());
    }
}
