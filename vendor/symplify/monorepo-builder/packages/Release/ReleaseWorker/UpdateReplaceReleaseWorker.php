<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use ConfigTransformer202301\PharIo\Version\Version;
use ConfigTransformer202301\Symplify\MonorepoBuilder\ComposerJsonManipulator\FileSystem\JsonFileManager;
use ConfigTransformer202301\Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Release\Exception\MissingComposerJsonException;
use ConfigTransformer202301\Symplify\SmartFileSystem\SmartFileInfo;
final class UpdateReplaceReleaseWorker implements ReleaseWorkerInterface
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
    public function work(Version $version) : void
    {
        $rootComposerJson = $this->composerJsonProvider->getRootComposerJson();
        $replace = $rootComposerJson->getReplace();
        $packageNames = $this->composerJsonProvider->getPackageNames();
        $newReplace = [];
        foreach (\array_keys($replace) as $package) {
            if (!\in_array($package, $packageNames, \true)) {
                continue;
            }
            $newReplace[$package] = $version->getVersionString();
        }
        if ($replace === $newReplace) {
            return;
        }
        $rootComposerJson->setReplace($newReplace);
        $rootFileInfo = $rootComposerJson->getFileInfo();
        if (!$rootFileInfo instanceof SmartFileInfo) {
            throw new MissingComposerJsonException();
        }
        $this->jsonFileManager->printJsonToFileInfo($rootComposerJson->getJsonArray(), $rootFileInfo);
    }
    public function getDescription(Version $version) : string
    {
        return 'Update "replace" version in "composer.json" to new tag to avoid circular dependencies conflicts';
    }
}
