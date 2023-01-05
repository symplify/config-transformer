<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use ConfigTransformer202301\PharIo\Version\Version;
use ConfigTransformer202301\Symplify\MonorepoBuilder\ConflictingUpdater;
use ConfigTransformer202301\Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Package\PackageNamesProvider;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Utils\VersionUtils;
final class SetCurrentMutualConflictsReleaseWorker implements ReleaseWorkerInterface
{
    /**
     * @var \Symplify\MonorepoBuilder\Utils\VersionUtils
     */
    private $versionUtils;
    /**
     * @var \Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider
     */
    private $composerJsonProvider;
    /**
     * @var \Symplify\MonorepoBuilder\Package\PackageNamesProvider
     */
    private $packageNamesProvider;
    /**
     * @var \Symplify\MonorepoBuilder\ConflictingUpdater
     */
    private $conflictingUpdater;
    public function __construct(VersionUtils $versionUtils, ComposerJsonProvider $composerJsonProvider, PackageNamesProvider $packageNamesProvider, ConflictingUpdater $conflictingUpdater)
    {
        $this->versionUtils = $versionUtils;
        $this->composerJsonProvider = $composerJsonProvider;
        $this->packageNamesProvider = $packageNamesProvider;
        $this->conflictingUpdater = $conflictingUpdater;
    }
    public function work(Version $version) : void
    {
        $this->conflictingUpdater->updateFileInfosWithVendorAndVersion($this->composerJsonProvider->getPackagesComposerFileInfos(), $this->packageNamesProvider->provide(), $version);
        // give time to propagate printed composer.json values before commit
        \sleep(1);
    }
    public function getDescription(Version $version) : string
    {
        $versionInString = $this->versionUtils->getRequiredFormat($version);
        return \sprintf('Set packages mutual conflicts to "%s" version', $versionInString);
    }
}
