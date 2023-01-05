<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use ConfigTransformer202301\PharIo\Version\Version;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Release\Process\ProcessRunner;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Utils\VersionUtils;
use ConfigTransformer202301\Symplify\MonorepoBuilder\ValueObject\Option;
use ConfigTransformer202301\Symplify\PackageBuilder\Parameter\ParameterProvider;
final class PushNextDevReleaseWorker implements ReleaseWorkerInterface
{
    /**
     * @var string
     */
    private $branchName;
    /**
     * @var \Symplify\MonorepoBuilder\Release\Process\ProcessRunner
     */
    private $processRunner;
    /**
     * @var \Symplify\MonorepoBuilder\Utils\VersionUtils
     */
    private $versionUtils;
    public function __construct(ProcessRunner $processRunner, VersionUtils $versionUtils, ParameterProvider $parameterProvider)
    {
        $this->processRunner = $processRunner;
        $this->versionUtils = $versionUtils;
        $this->branchName = $parameterProvider->provideStringParameter(Option::DEFAULT_BRANCH_NAME);
    }
    public function work(Version $version) : void
    {
        $versionInString = $this->getVersionDev($version);
        $gitAddCommitCommand = \sprintf('git add . && git commit --allow-empty -m "open %s" && git push origin "%s"', $versionInString, $this->branchName);
        $this->processRunner->run($gitAddCommitCommand);
    }
    public function getDescription(Version $version) : string
    {
        $versionInString = $this->getVersionDev($version);
        return \sprintf('Push "%s" open to remote repository', $versionInString);
    }
    private function getVersionDev(Version $version) : string
    {
        return $this->versionUtils->getNextAliasFormat($version);
    }
}
