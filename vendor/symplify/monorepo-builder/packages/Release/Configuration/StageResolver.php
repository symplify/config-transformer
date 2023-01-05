<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Release\Configuration;

use ConfigTransformer202301\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Release\Guard\ReleaseGuard;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Release\ValueObject\Stage;
use ConfigTransformer202301\Symplify\MonorepoBuilder\ValueObject\Option;
final class StageResolver
{
    /**
     * @var \Symplify\MonorepoBuilder\Release\Guard\ReleaseGuard
     */
    private $releaseGuard;
    public function __construct(ReleaseGuard $releaseGuard)
    {
        $this->releaseGuard = $releaseGuard;
    }
    public function resolveFromInput(InputInterface $input) : string
    {
        $stage = (string) $input->getOption(Option::STAGE);
        // empty
        if ($stage === Stage::MAIN) {
            $this->releaseGuard->guardRequiredStageOnEmptyStage();
        } else {
            $this->releaseGuard->guardStage($stage);
        }
        return $stage;
    }
}
