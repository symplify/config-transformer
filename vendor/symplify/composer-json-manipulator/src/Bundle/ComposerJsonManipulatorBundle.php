<?php

declare (strict_types=1);
namespace ConfigTransformer202106139\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer202106139\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202106139\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer202106139\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer202106139\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202106139\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
