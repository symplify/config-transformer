<?php

declare (strict_types=1);
namespace ConfigTransformer202107036\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer202107036\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202107036\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer202107036\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer202107036\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202107036\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
