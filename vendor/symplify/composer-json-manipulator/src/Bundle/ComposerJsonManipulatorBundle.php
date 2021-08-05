<?php

declare (strict_types=1);
namespace ConfigTransformer202108055\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer202108055\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202108055\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer202108055\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer202108055\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202108055\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
