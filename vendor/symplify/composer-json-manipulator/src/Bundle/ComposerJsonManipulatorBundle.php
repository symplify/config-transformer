<?php

declare (strict_types=1);
namespace ConfigTransformer202110205\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer202110205\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202110205\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer202110205\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer202110205\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202110205\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
