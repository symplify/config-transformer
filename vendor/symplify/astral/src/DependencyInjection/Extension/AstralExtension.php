<?php

declare (strict_types=1);
namespace ConfigTransformer2021101210\Symplify\Astral\DependencyInjection\Extension;

use ConfigTransformer2021101210\Symfony\Component\Config\FileLocator;
use ConfigTransformer2021101210\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2021101210\Symfony\Component\DependencyInjection\Extension\Extension;
use ConfigTransformer2021101210\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class AstralExtension extends \ConfigTransformer2021101210\Symfony\Component\DependencyInjection\Extension\Extension
{
    /**
     * @param string[] $configs
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function load($configs, $containerBuilder) : void
    {
        $phpFileLoader = new \ConfigTransformer2021101210\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \ConfigTransformer2021101210\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
