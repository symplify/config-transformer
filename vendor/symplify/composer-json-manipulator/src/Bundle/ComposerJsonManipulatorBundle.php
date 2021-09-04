<?php

declare (strict_types=1);
namespace ConfigTransformer202109046\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer202109046\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202109046\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer202109046\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer202109046\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202109046\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
