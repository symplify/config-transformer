<?php

declare (strict_types=1);
namespace ConfigTransformer202107232\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer202107232\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202107232\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer202107232\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer202107232\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202107232\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
