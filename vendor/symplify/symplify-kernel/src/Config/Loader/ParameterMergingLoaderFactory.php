<?php

declare (strict_types=1);
namespace ConfigTransformer2021113010\Symplify\SymplifyKernel\Config\Loader;

use ConfigTransformer2021113010\Symfony\Component\Config\FileLocator;
use ConfigTransformer2021113010\Symfony\Component\Config\Loader\DelegatingLoader;
use ConfigTransformer2021113010\Symfony\Component\Config\Loader\GlobFileLoader;
use ConfigTransformer2021113010\Symfony\Component\Config\Loader\LoaderResolver;
use ConfigTransformer2021113010\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2021113010\Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader;
use ConfigTransformer2021113010\Symplify\SymplifyKernel\Contract\Config\LoaderFactoryInterface;
final class ParameterMergingLoaderFactory implements \ConfigTransformer2021113010\Symplify\SymplifyKernel\Contract\Config\LoaderFactoryInterface
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     * @param string $currentWorkingDirectory
     */
    public function create($containerBuilder, $currentWorkingDirectory) : \ConfigTransformer2021113010\Symfony\Component\Config\Loader\LoaderInterface
    {
        $fileLocator = new \ConfigTransformer2021113010\Symfony\Component\Config\FileLocator([$currentWorkingDirectory]);
        $loaders = [new \ConfigTransformer2021113010\Symfony\Component\Config\Loader\GlobFileLoader($fileLocator), new \ConfigTransformer2021113010\Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader($containerBuilder, $fileLocator)];
        $loaderResolver = new \ConfigTransformer2021113010\Symfony\Component\Config\Loader\LoaderResolver($loaders);
        return new \ConfigTransformer2021113010\Symfony\Component\Config\Loader\DelegatingLoader($loaderResolver);
    }
}
