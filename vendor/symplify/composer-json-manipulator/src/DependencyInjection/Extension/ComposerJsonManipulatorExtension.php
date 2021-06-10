<?php

declare (strict_types=1);
namespace ConfigTransformer20210610\Symplify\ComposerJsonManipulator\DependencyInjection\Extension;

use ConfigTransformer20210610\Symfony\Component\Config\FileLocator;
use ConfigTransformer20210610\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer20210610\Symfony\Component\DependencyInjection\Extension\Extension;
use ConfigTransformer20210610\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class ComposerJsonManipulatorExtension extends \ConfigTransformer20210610\Symfony\Component\DependencyInjection\Extension\Extension
{
    /**
     * @param string[] $configs
     */
    public function load(array $configs, \ConfigTransformer20210610\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \ConfigTransformer20210610\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \ConfigTransformer20210610\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
