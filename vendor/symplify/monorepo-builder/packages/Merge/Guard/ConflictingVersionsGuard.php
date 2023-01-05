<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\Guard;

use ConfigTransformer202301\Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Validator\ConflictingPackageVersionsReporter;
use ConfigTransformer202301\Symplify\MonorepoBuilder\VersionValidator;
use ConfigTransformer202301\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class ConflictingVersionsGuard
{
    /**
     * @var \Symplify\MonorepoBuilder\VersionValidator
     */
    private $versionValidator;
    /**
     * @var \Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider
     */
    private $composerJsonProvider;
    /**
     * @var \Symplify\MonorepoBuilder\Validator\ConflictingPackageVersionsReporter
     */
    private $conflictingPackageVersionsReporter;
    public function __construct(VersionValidator $versionValidator, ComposerJsonProvider $composerJsonProvider, ConflictingPackageVersionsReporter $conflictingPackageVersionsReporter)
    {
        $this->versionValidator = $versionValidator;
        $this->composerJsonProvider = $composerJsonProvider;
        $this->conflictingPackageVersionsReporter = $conflictingPackageVersionsReporter;
    }
    public function ensureNoConflictingPackageVersions() : void
    {
        $conflictingPackageVersions = $this->versionValidator->findConflictingPackageVersionsInFileInfos($this->composerJsonProvider->getPackagesComposerFileInfos());
        if ($conflictingPackageVersions === []) {
            return;
        }
        $this->conflictingPackageVersionsReporter->report($conflictingPackageVersions);
        throw new ShouldNotHappenException('Fix conflicting package version first');
    }
}
