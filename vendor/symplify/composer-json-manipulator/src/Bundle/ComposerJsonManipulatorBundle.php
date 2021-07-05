<?php

declare (strict_types=1);
namespace ConfigTransformer2021070510\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer2021070510\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer2021070510\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer2021070510\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer2021070510\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer2021070510\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
