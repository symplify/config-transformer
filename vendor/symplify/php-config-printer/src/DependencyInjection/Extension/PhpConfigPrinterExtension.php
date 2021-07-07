<?php

declare (strict_types=1);
namespace ConfigTransformer2021070710\Symplify\PhpConfigPrinter\DependencyInjection\Extension;

use ConfigTransformer2021070710\Symfony\Component\Config\FileLocator;
use ConfigTransformer2021070710\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2021070710\Symfony\Component\DependencyInjection\Extension\Extension;
use ConfigTransformer2021070710\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class PhpConfigPrinterExtension extends \ConfigTransformer2021070710\Symfony\Component\DependencyInjection\Extension\Extension
{
    /**
     * @param string[] $configs
     */
    public function load(array $configs, \ConfigTransformer2021070710\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        // needed for parameter shifting of sniff/fixer params
        $phpFileLoader = new \ConfigTransformer2021070710\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \ConfigTransformer2021070710\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
