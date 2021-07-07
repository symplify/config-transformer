<?php

declare (strict_types=1);
namespace ConfigTransformer202107076\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer202107076\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202107076\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer202107076\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer202107076\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202107076\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
