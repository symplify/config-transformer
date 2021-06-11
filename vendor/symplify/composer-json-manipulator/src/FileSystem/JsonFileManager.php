<?php

declare (strict_types=1);
namespace ConfigTransformer2021061110\Symplify\ComposerJsonManipulator\FileSystem;

use ConfigTransformer2021061110\Nette\Utils\Json;
use ConfigTransformer2021061110\Symplify\ComposerJsonManipulator\Json\JsonCleaner;
use ConfigTransformer2021061110\Symplify\ComposerJsonManipulator\Json\JsonInliner;
use ConfigTransformer2021061110\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use ConfigTransformer2021061110\Symplify\PackageBuilder\Configuration\StaticEolConfiguration;
use ConfigTransformer2021061110\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer2021061110\Symplify\SmartFileSystem\SmartFileSystem;
/**
 * @see \Symplify\MonorepoBuilder\Tests\FileSystem\JsonFileManager\JsonFileManagerTest
 */
final class JsonFileManager
{
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var JsonCleaner
     */
    private $jsonCleaner;
    /**
     * @var JsonInliner
     */
    private $jsonInliner;
    /**
     * @var mixed[]
     */
    private $cachedJSONFiles = [];
    public function __construct(\ConfigTransformer2021061110\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \ConfigTransformer2021061110\Symplify\ComposerJsonManipulator\Json\JsonCleaner $jsonCleaner, \ConfigTransformer2021061110\Symplify\ComposerJsonManipulator\Json\JsonInliner $jsonInliner)
    {
        $this->smartFileSystem = $smartFileSystem;
        $this->jsonCleaner = $jsonCleaner;
        $this->jsonInliner = $jsonInliner;
    }
    /**
     * @return mixed[]
     */
    public function loadFromFileInfo(\ConfigTransformer2021061110\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : array
    {
        $realPath = $smartFileInfo->getRealPath();
        if (!isset($this->cachedJSONFiles[$realPath])) {
            $this->cachedJSONFiles[$realPath] = \ConfigTransformer2021061110\Nette\Utils\Json::decode($smartFileInfo->getContents(), \ConfigTransformer2021061110\Nette\Utils\Json::FORCE_ARRAY);
        }
        return $this->cachedJSONFiles[$realPath];
    }
    /**
     * @return array<string, mixed>
     */
    public function loadFromFilePath(string $filePath) : array
    {
        $fileContent = $this->smartFileSystem->readFile($filePath);
        return \ConfigTransformer2021061110\Nette\Utils\Json::decode($fileContent, \ConfigTransformer2021061110\Nette\Utils\Json::FORCE_ARRAY);
    }
    /**
     * @param mixed[] $json
     */
    public function printJsonToFileInfo(array $json, \ConfigTransformer2021061110\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        $jsonString = $this->encodeJsonToFileContent($json);
        $this->smartFileSystem->dumpFile($smartFileInfo->getPathname(), $jsonString);
        return $jsonString;
    }
    public function printComposerJsonToFilePath(\ConfigTransformer2021061110\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson, string $filePath) : string
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
        $jsonContent = \ConfigTransformer2021061110\Nette\Utils\Json::encode($json, \ConfigTransformer2021061110\Nette\Utils\Json::PRETTY) . \ConfigTransformer2021061110\Symplify\PackageBuilder\Configuration\StaticEolConfiguration::getEolChar();
        return $this->jsonInliner->inlineSections($jsonContent);
    }
}
