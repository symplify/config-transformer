<?php

declare (strict_types=1);
namespace ConfigTransformer202109202\Symplify\SymplifyKernel\DependencyInjection\Extension;

use ConfigTransformer202109202\Symfony\Component\Config\FileLocator;
use ConfigTransformer202109202\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202109202\Symfony\Component\DependencyInjection\Extension\Extension;
use ConfigTransformer202109202\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class SymplifyKernelExtension extends \ConfigTransformer202109202\Symfony\Component\DependencyInjection\Extension\Extension
{
    /**
     * @param string[] $configs
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function load($configs, $containerBuilder) : void
    {
        $phpFileLoader = new \ConfigTransformer202109202\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \ConfigTransformer202109202\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('common-config.php');
    }
}
