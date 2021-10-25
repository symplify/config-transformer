<?php

declare (strict_types=1);
namespace ConfigTransformer202110259\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer202110259\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202110259\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer202110259\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer202110259\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202110259\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
