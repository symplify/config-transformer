<?php

declare (strict_types=1);
namespace ConfigTransformer202106139\Symplify\ComposerJsonManipulator\FileSystem;

use ConfigTransformer202106139\Nette\Utils\Json;
use ConfigTransformer202106139\Symplify\ComposerJsonManipulator\Json\JsonCleaner;
use ConfigTransformer202106139\Symplify\ComposerJsonManipulator\Json\JsonInliner;
use ConfigTransformer202106139\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use ConfigTransformer202106139\Symplify\PackageBuilder\Configuration\StaticEolConfiguration;
use ConfigTransformer202106139\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer202106139\Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\ConfigTransformer202106139\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \ConfigTransformer202106139\Symplify\ComposerJsonManipulator\Json\JsonCleaner $jsonCleaner, \ConfigTransformer202106139\Symplify\ComposerJsonManipulator\Json\JsonInliner $jsonInliner)
    {
        $this->smartFileSystem = $smartFileSystem;
        $this->jsonCleaner = $jsonCleaner;
        $this->jsonInliner = $jsonInliner;
    }
    /**
     * @return mixed[]
     */
    public function loadFromFileInfo(\ConfigTransformer202106139\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : array
    {
        $realPath = $smartFileInfo->getRealPath();
        if (!isset($this->cachedJSONFiles[$realPath])) {
            $this->cachedJSONFiles[$realPath] = \ConfigTransformer202106139\Nette\Utils\Json::decode($smartFileInfo->getContents(), \ConfigTransformer202106139\Nette\Utils\Json::FORCE_ARRAY);
        }
        return $this->cachedJSONFiles[$realPath];
    }
    /**
     * @return array<string, mixed>
     */
    public function loadFromFilePath(string $filePath) : array
    {
        $fileContent = $this->smartFileSystem->readFile($filePath);
        return \ConfigTransformer202106139\Nette\Utils\Json::decode($fileContent, \ConfigTransformer202106139\Nette\Utils\Json::FORCE_ARRAY);
    }
    /**
     * @param mixed[] $json
     */
    public function printJsonToFileInfo(array $json, \ConfigTransformer202106139\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        $jsonString = $this->encodeJsonToFileContent($json);
        $this->smartFileSystem->dumpFile($smartFileInfo->getPathname(), $jsonString);
        return $jsonString;
    }
    public function printComposerJsonToFilePath(\ConfigTransformer202106139\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson, string $filePath) : string
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
        $jsonContent = \ConfigTransformer202106139\Nette\Utils\Json::encode($json, \ConfigTransformer202106139\Nette\Utils\Json::PRETTY) . \ConfigTransformer202106139\Symplify\PackageBuilder\Configuration\StaticEolConfiguration::getEolChar();
        return $this->jsonInliner->inlineSections($jsonContent);
    }
}
