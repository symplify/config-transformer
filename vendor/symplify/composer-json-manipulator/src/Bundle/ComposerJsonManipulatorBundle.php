<?php

declare (strict_types=1);
namespace ConfigTransformer202107088\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer202107088\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202107088\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer202107088\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer202107088\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202107088\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
