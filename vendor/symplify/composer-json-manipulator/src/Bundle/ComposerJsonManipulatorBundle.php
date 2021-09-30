<?php

declare (strict_types=1);
namespace ConfigTransformer202109303\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer202109303\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202109303\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer202109303\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer202109303\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202109303\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
