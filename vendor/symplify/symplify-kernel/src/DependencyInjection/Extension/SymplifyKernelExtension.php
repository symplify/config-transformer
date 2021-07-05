<?php

declare (strict_types=1);
namespace ConfigTransformer202107055\Symplify\SymplifyKernel\DependencyInjection\Extension;

use ConfigTransformer202107055\Symfony\Component\Config\FileLocator;
use ConfigTransformer202107055\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202107055\Symfony\Component\DependencyInjection\Extension\Extension;
use ConfigTransformer202107055\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class SymplifyKernelExtension extends \ConfigTransformer202107055\Symfony\Component\DependencyInjection\Extension\Extension
{
    /**
     * @param string[] $configs
     */
    public function load(array $configs, \ConfigTransformer202107055\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \ConfigTransformer202107055\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \ConfigTransformer202107055\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('common-config.php');
    }
}
