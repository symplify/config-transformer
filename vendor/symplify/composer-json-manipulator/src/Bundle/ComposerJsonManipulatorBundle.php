<?php

declare (strict_types=1);
namespace ConfigTransformer2021081610\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer2021081610\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer2021081610\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer2021081610\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer2021081610\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer2021081610\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
