<?php

declare (strict_types=1);
namespace ConfigTransformer202106117\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer202106117\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202106117\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer202106117\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer202106117\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202106117\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
