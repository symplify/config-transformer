<?php

declare (strict_types=1);
namespace ConfigTransformer20210610\Symplify\ComposerJsonManipulator\Bundle;

use ConfigTransformer20210610\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer20210610\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension;
final class ComposerJsonManipulatorBundle extends \ConfigTransformer20210610\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer20210610\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer20210610\Symplify\ComposerJsonManipulator\DependencyInjection\Extension\ComposerJsonManipulatorExtension();
    }
}
