<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use ConfigTransformer202301\PharIo\Version\Version;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Release\Process\ProcessRunner;
final class PushTagReleaseWorker implements ReleaseWorkerInterface
{
    /**
     * @var \Symplify\MonorepoBuilder\Release\Process\ProcessRunner
     */
    private $processRunner;
    public function __construct(ProcessRunner $processRunner)
    {
        $this->processRunner = $processRunner;
    }
    public function work(Version $version) : void
    {
        $this->processRunner->run('git push --tags');
    }
    public function getDescription(Version $version) : string
    {
        return \sprintf('Push "%s" tag to remote repository', $version->getVersionString());
    }
}
