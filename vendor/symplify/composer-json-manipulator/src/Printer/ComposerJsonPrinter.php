<?php

declare (strict_types=1);
namespace ConfigTransformer2021101210\Symplify\ComposerJsonManipulator\Printer;

use ConfigTransformer2021101210\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use ConfigTransformer2021101210\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use ConfigTransformer2021101210\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @api
 */
final class ComposerJsonPrinter
{
    /**
     * @var \Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager
     */
    private $jsonFileManager;
    public function __construct(\ConfigTransformer2021101210\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager $jsonFileManager)
    {
        $this->jsonFileManager = $jsonFileManager;
    }
    /**
     * @param string|\Symplify\SmartFileSystem\SmartFileInfo $targetFile
     */
    public function print(\ConfigTransformer2021101210\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson, $targetFile) : string
    {
        if (\is_string($targetFile)) {
            return $this->jsonFileManager->printComposerJsonToFilePath($composerJson, $targetFile);
        }
        return $this->jsonFileManager->printJsonToFileInfo($composerJson->getJsonArray(), $targetFile);
    }
}
