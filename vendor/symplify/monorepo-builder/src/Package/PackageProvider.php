<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Package;

use ConfigTransformer202301\Symplify\MonorepoBuilder\ComposerJsonManipulator\FileSystem\JsonFileManager;
use ConfigTransformer202301\Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use ConfigTransformer202301\Symplify\MonorepoBuilder\ValueObject\Package;
use ConfigTransformer202301\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer202301\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class PackageProvider
{
    /**
     * @var \Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider
     */
    private $composerJsonProvider;
    /**
     * @var \Symplify\MonorepoBuilder\ComposerJsonManipulator\FileSystem\JsonFileManager
     */
    private $jsonFileManager;
    public function __construct(ComposerJsonProvider $composerJsonProvider, JsonFileManager $jsonFileManager)
    {
        $this->composerJsonProvider = $composerJsonProvider;
        $this->jsonFileManager = $jsonFileManager;
    }
    /**
     * @return Package[]
     */
    public function provide() : array
    {
        $packages = [];
        foreach ($this->composerJsonProvider->getPackagesComposerFileInfos() as $packagesComposerFileInfo) {
            $packageName = $this->detectNameFromFileInfo($packagesComposerFileInfo);
            $hasTests = \file_exists($packagesComposerFileInfo->getRealPathDirectory() . '/tests');
            $packages[] = new Package($packageName, $hasTests);
        }
        \usort($packages, static function (Package $firstPackage, Package $secondPackage) : int {
            return $firstPackage->getShortName() <=> $secondPackage->getShortName();
        });
        return $packages;
    }
    private function detectNameFromFileInfo(SmartFileInfo $smartFileInfo) : string
    {
        $json = $this->jsonFileManager->loadFromFileInfo($smartFileInfo);
        if (!isset($json['name'])) {
            $errorMessage = \sprintf('Package "name" is missing in "composer.json" for "%s"', $smartFileInfo->getRelativeFilePathFromCwd());
            throw new ShouldNotHappenException($errorMessage);
        }
        return (string) $json['name'];
    }
}
