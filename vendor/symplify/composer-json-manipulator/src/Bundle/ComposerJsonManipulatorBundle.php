<?php

declare (strict_types=1);
namespace ConfigTransformer202108230\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer202108230\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202108230\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer202108230\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer202108230\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202108230\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
