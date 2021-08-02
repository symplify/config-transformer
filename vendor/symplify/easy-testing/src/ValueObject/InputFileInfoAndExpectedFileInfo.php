<?php

declare (strict_types=1);
namespace ConfigTransformer202108024\Symplify\EasyTesting\ValueObject;

use ConfigTransformer202108024\Symplify\SmartFileSystem\SmartFileInfo;
final class InputFileInfoAndExpectedFileInfo
{
    /**
     * @var \Symplify\SmartFileSystem\SmartFileInfo
     */
    private $inputFileInfo;
    /**
     * @var \Symplify\SmartFileSystem\SmartFileInfo
     */
    private $expectedFileInfo;
    public function __construct(\ConfigTransformer202108024\Symplify\SmartFileSystem\SmartFileInfo $inputFileInfo, \ConfigTransformer202108024\Symplify\SmartFileSystem\SmartFileInfo $expectedFileInfo)
    {
        $this->inputFileInfo = $inputFileInfo;
        $this->expectedFileInfo = $expectedFileInfo;
    }
    public function getInputFileInfo() : \ConfigTransformer202108024\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->inputFileInfo;
    }
    public function getExpectedFileInfo() : \ConfigTransformer202108024\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->expectedFileInfo;
    }
    public function getExpectedFileContent() : string
    {
        return $this->expectedFileInfo->getContents();
    }
    public function getExpectedFileInfoRealPath() : string
    {
        return $this->expectedFileInfo->getRealPath();
    }
}
