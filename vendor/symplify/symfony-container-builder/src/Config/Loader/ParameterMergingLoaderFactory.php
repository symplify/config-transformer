<?php

declare (strict_types=1);
namespace ConfigTransformer202110318\Symplify\SymfonyContainerBuilder\Config\Loader;

use ConfigTransformer202110318\Symfony\Component\Config\FileLocator;
use ConfigTransformer202110318\Symfony\Component\Config\Loader\DelegatingLoader;
use ConfigTransformer202110318\Symfony\Component\Config\Loader\GlobFileLoader;
use ConfigTransformer202110318\Symfony\Component\Config\Loader\LoaderResolver;
use ConfigTransformer202110318\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202110318\Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader;
final class ParameterMergingLoaderFactory
{
    public function create(\ConfigTransformer202110318\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202110318\Symfony\Component\Config\Loader\DelegatingLoader
    {
        $fileLocator = new \ConfigTransformer202110318\Symfony\Component\Config\FileLocator([$currentWorkingDirectory]);
        $loaders = [new \ConfigTransformer202110318\Symfony\Component\Config\Loader\GlobFileLoader($fileLocator), new \ConfigTransformer202110318\Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader($containerBuilder, $fileLocator)];
        $loaderResolver = new \ConfigTransformer202110318\Symfony\Component\Config\Loader\LoaderResolver($loaders);
        return new \ConfigTransformer202110318\Symfony\Component\Config\Loader\DelegatingLoader($loaderResolver);
    }
}
