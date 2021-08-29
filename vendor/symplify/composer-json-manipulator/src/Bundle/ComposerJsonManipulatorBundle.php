<?php

declare (strict_types=1);
namespace ConfigTransformer2021082910\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer2021082910\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer2021082910\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer2021082910\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer2021082910\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer2021082910\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
