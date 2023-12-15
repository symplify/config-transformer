<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Tests\Helper\ValueObject;

use Symfony\Component\Finder\SplFileInfo;

final class InputFileInfoAndExpectedFileInfo
{
    public function __construct(
        private readonly SplFileInfo $inputFileInfo,
        private readonly SplFileInfo $expectedFileInfo
    ) {
    }

    public function getInputFileInfo(): SplFileInfo
    {
        return $this->inputFileInfo;
    }

    public function getExpectedFileInfo(): SplFileInfo
    {
        return $this->expectedFileInfo;
    }

    public function getExpectedFileContent(): string
    {
        return $this->expectedFileInfo->getContents();
    }

    public function getExpectedFileInfoRealPath(): string
    {
        return $this->expectedFileInfo->getRealPath();
    }
}
