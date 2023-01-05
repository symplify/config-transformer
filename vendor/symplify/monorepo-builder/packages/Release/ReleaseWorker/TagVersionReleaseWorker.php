<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use ConfigTransformer202301\PharIo\Version\Version;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Release\Process\ProcessRunner;
use ConfigTransformer202301\Symplify\MonorepoBuilder\ValueObject\Option;
use ConfigTransformer202301\Symplify\PackageBuilder\Parameter\ParameterProvider;
use Throwable;
final class TagVersionReleaseWorker implements ReleaseWorkerInterface
{
    /**
     * @var string
     */
    private $branchName;
    /**
     * @var \Symplify\MonorepoBuilder\Release\Process\ProcessRunner
     */
    private $processRunner;
    public function __construct(ProcessRunner $processRunner, ParameterProvider $parameterProvider)
    {
        $this->processRunner = $processRunner;
        $this->branchName = $parameterProvider->provideStringParameter(Option::DEFAULT_BRANCH_NAME);
    }
    public function work(Version $version) : void
    {
        try {
            $gitAddCommitCommand = \sprintf('git add . && git commit -m "prepare release" && git push origin "%s"', $this->branchName);
            $this->processRunner->run($gitAddCommitCommand);
        } catch (Throwable $exception) {
            // nothing to commit
        }
        $this->processRunner->run('git tag ' . $version->getOriginalString());
    }
    public function getDescription(Version $version) : string
    {
        return \sprintf('Add local tag "%s"', $version->getOriginalString());
    }
}
