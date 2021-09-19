<?php

declare (strict_types=1);
namespace ConfigTransformer202109197\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer202109197\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202109197\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer202109197\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer202109197\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202109197\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
