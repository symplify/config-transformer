<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\Contract;

use ConfigTransformer202301\Symplify\MonorepoBuilder\ComposerJsonManipulator\ValueObject\ComposerJson;
interface ComposerJsonDecoratorInterface
{
    public function decorate(ComposerJson $composerJson) : void;
}
