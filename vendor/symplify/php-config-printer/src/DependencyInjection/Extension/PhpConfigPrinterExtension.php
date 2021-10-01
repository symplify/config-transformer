<?php

declare (strict_types=1);
namespace ConfigTransformer202110017\Symplify\PhpConfigPrinter\DependencyInjection\Extension;

use ConfigTransformer202110017\Symfony\Component\Config\FileLocator;
use ConfigTransformer202110017\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202110017\Symfony\Component\DependencyInjection\Extension\Extension;
use ConfigTransformer202110017\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class PhpConfigPrinterExtension extends \ConfigTransformer202110017\Symfony\Component\DependencyInjection\Extension\Extension
{
    /**
     * @param string[] $configs
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function load($configs, $containerBuilder) : void
    {
        // needed for parameter shifting of sniff/fixer params
        $phpFileLoader = new \ConfigTransformer202110017\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \ConfigTransformer202110017\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
