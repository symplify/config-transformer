<?php

declare (strict_types=1);
namespace ConfigTransformer202108111\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer202108111\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202108111\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer202108111\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer202108111\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202108111\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
