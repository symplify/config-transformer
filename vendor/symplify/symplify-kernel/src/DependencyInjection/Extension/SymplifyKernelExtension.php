<?php

declare (strict_types=1);
namespace ConfigTransformer20210606\Symplify\SymplifyKernel\DependencyInjection\Extension;

use ConfigTransformer20210606\Symfony\Component\Config\FileLocator;
use ConfigTransformer20210606\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer20210606\Symfony\Component\DependencyInjection\Extension\Extension;
use ConfigTransformer20210606\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class SymplifyKernelExtension extends \ConfigTransformer20210606\Symfony\Component\DependencyInjection\Extension\Extension
{
    /**
     * @param string[] $configs
     */
    public function load(array $configs, \ConfigTransformer20210606\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \ConfigTransformer20210606\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \ConfigTransformer20210606\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('common-config.php');
    }
}
