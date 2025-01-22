<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\ValueObject;

use Nette\Utils\Strings;
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
        $relativeFilePathWithoutSuffix = Strings::before($originalRelativeFilePath, '.', -1);

        return $relativeFilePathWithoutSuffix . '.php';
    }

    public function getOriginalFilePathWithoutSuffix(): string
    {
        return Strings::replace($this->originalFileInfo->getRealPath(), self::LAST_SUFFIX_REGEX, '');
    }

    public function getOriginalRelativeFilePath(): string
    {
        return RelativeFilePathHelper::resolveFromDirectory($this->originalFileInfo->getRealPath(), getcwd());
    }
}
