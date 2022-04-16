<?php

declare (strict_types=1);
namespace ConfigTransformer202204164\Symplify\SymplifyKernel\Config\Loader;

use ConfigTransformer202204164\Symfony\Component\Config\FileLocator;
use ConfigTransformer202204164\Symfony\Component\Config\Loader\DelegatingLoader;
use ConfigTransformer202204164\Symfony\Component\Config\Loader\GlobFileLoader;
use ConfigTransformer202204164\Symfony\Component\Config\Loader\LoaderResolver;
use ConfigTransformer202204164\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202204164\Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader;
use ConfigTransformer202204164\Symplify\SymplifyKernel\Contract\Config\LoaderFactoryInterface;
final class ParameterMergingLoaderFactory implements \ConfigTransformer202204164\Symplify\SymplifyKernel\Contract\Config\LoaderFactoryInterface
{
    public function create(\ConfigTransformer202204164\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202204164\Symfony\Component\Config\Loader\LoaderInterface
    {
        $fileLocator = new \ConfigTransformer202204164\Symfony\Component\Config\FileLocator([$currentWorkingDirectory]);
        $loaders = [new \ConfigTransformer202204164\Symfony\Component\Config\Loader\GlobFileLoader($fileLocator), new \ConfigTransformer202204164\Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader($containerBuilder, $fileLocator)];
        $loaderResolver = new \ConfigTransformer202204164\Symfony\Component\Config\Loader\LoaderResolver($loaders);
        return new \ConfigTransformer202204164\Symfony\Component\Config\Loader\DelegatingLoader($loaderResolver);
    }
}
