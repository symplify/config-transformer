<?php

declare (strict_types=1);
namespace ConfigTransformer202108221\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer202108221\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202108221\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer202108221\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer202108221\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202108221\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
