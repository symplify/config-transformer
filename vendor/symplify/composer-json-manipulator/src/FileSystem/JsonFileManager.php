<?php

declare (strict_types=1);
namespace ConfigTransformer202109220\Symplify\ComposerJsonManipulator\FileSystem;

use ConfigTransformer202109220\Nette\Utils\Json;
use ConfigTransformer202109220\Symplify\ComposerJsonManipulator\Json\JsonCleaner;
use ConfigTransformer202109220\Symplify\ComposerJsonManipulator\Json\JsonInliner;
use ConfigTransformer202109220\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use ConfigTransformer202109220\Symplify\PackageBuilder\Configuration\StaticEolConfiguration;
use ConfigTransformer202109220\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer202109220\Symplify\SmartFileSystem\SmartFileSystem;
/**
 * @see \Symplify\MonorepoBuilder\Tests\FileSystem\JsonFileManager\JsonFileManagerTest
 */
final class JsonFileManager
{
    /**
     * @var mixed[]
     */
    private $cachedJSONFiles = [];
    /**
     * @var \Symplify\SmartFileSystem\SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var \Symplify\ComposerJsonManipulator\Json\JsonCleaner
     */
    private $jsonCleaner;
    /**
     * @var \Symplify\ComposerJsonManipulator\Json\JsonInliner
     */
    private $jsonInliner;
    public function __construct(\ConfigTransformer202109220\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \ConfigTransformer202109220\Symplify\ComposerJsonManipulator\Json\JsonCleaner $jsonCleaner, \ConfigTransformer202109220\Symplify\ComposerJsonManipulator\Json\JsonInliner $jsonInliner)
    {
        $this->smartFileSystem = $smartFileSystem;
        $this->jsonCleaner = $jsonCleaner;
        $this->jsonInliner = $jsonInliner;
    }
    /**
     * @return mixed[]
     */
    public function loadFromFileInfo(\ConfigTransformer202109220\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : array
    {
        $realPath = $smartFileInfo->getRealPath();
        if (!isset($this->cachedJSONFiles[$realPath])) {
            $this->cachedJSONFiles[$realPath] = \ConfigTransformer202109220\Nette\Utils\Json::decode($smartFileInfo->getContents(), \ConfigTransformer202109220\Nette\Utils\Json::FORCE_ARRAY);
        }
        return $this->cachedJSONFiles[$realPath];
    }
    /**
     * @return array<string, mixed>
     */
    public function loadFromFilePath(string $filePath) : array
    {
        $fileContent = $this->smartFileSystem->readFile($filePath);
        return \ConfigTransformer202109220\Nette\Utils\Json::decode($fileContent, \ConfigTransformer202109220\Nette\Utils\Json::FORCE_ARRAY);
    }
    /**
     * @param mixed[] $json
     */
    public function printJsonToFileInfo(array $json, \ConfigTransformer202109220\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        $jsonString = $this->encodeJsonToFileContent($json);
        $this->smartFileSystem->dumpFile($smartFileInfo->getPathname(), $jsonString);
        $realPath = $smartFileInfo->getRealPath();
        unset($this->cachedJSONFiles[$realPath]);
        return $jsonString;
    }
    public function printComposerJsonToFilePath(\ConfigTransformer202109220\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson, string $filePath) : string
    {
        $jsonString = $this->encodeJsonToFileContent($composerJson->getJsonArray());
        $this->smartFileSystem->dumpFile($filePath, $jsonString);
        return $jsonString;
    }
    /**
     * @param mixed[] $json
     */
    public function encodeJsonToFileContent(array $json) : string
    {
        // Empty arrays may lead to bad encoding since we can't be sure whether they need to be arrays or objects.
        $json = $this->jsonCleaner->removeEmptyKeysFromJsonArray($json);
        $jsonContent = \ConfigTransformer202109220\Nette\Utils\Json::encode($json, \ConfigTransformer202109220\Nette\Utils\Json::PRETTY) . \ConfigTransformer202109220\Symplify\PackageBuilder\Configuration\StaticEolConfiguration::getEolChar();
        return $this->jsonInliner->inlineSections($jsonContent);
    }
}
