<?php

declare (strict_types=1);
namespace ConfigTransformer202109295\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer202109295\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202109295\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer202109295\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer202109295\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202109295\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
