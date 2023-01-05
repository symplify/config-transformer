<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use ConfigTransformer202301\PharIo\Version\Version;
use ConfigTransformer202301\Symplify\MonorepoBuilder\DependencyUpdater;
use ConfigTransformer202301\Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Package\PackageNamesProvider;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Utils\VersionUtils;
final class SetNextMutualDependenciesReleaseWorker implements ReleaseWorkerInterface
{
    /**
     * @var \Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider
     */
    private $composerJsonProvider;
    /**
     * @var \Symplify\MonorepoBuilder\DependencyUpdater
     */
    private $dependencyUpdater;
    /**
     * @var \Symplify\MonorepoBuilder\Package\PackageNamesProvider
     */
    private $packageNamesProvider;
    /**
     * @var \Symplify\MonorepoBuilder\Utils\VersionUtils
     */
    private $versionUtils;
    public function __construct(ComposerJsonProvider $composerJsonProvider, DependencyUpdater $dependencyUpdater, PackageNamesProvider $packageNamesProvider, VersionUtils $versionUtils)
    {
        $this->composerJsonProvider = $composerJsonProvider;
        $this->dependencyUpdater = $dependencyUpdater;
        $this->packageNamesProvider = $packageNamesProvider;
        $this->versionUtils = $versionUtils;
    }
    public function work(Version $version) : void
    {
        $versionInString = $this->versionUtils->getRequiredNextFormat($version);
        $this->dependencyUpdater->updateFileInfosWithPackagesAndVersion($this->composerJsonProvider->getPackagesComposerFileInfos(), $this->packageNamesProvider->provide(), $versionInString);
    }
    public function getDescription(Version $version) : string
    {
        $versionInString = $this->versionUtils->getRequiredNextFormat($version);
        return \sprintf('Set packages mutual dependencies to "%s" (alias of dev version)', $versionInString);
    }
}
