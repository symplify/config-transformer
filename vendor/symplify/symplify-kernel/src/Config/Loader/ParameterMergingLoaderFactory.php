<?php

declare (strict_types=1);
namespace ConfigTransformer202111242\Symplify\SymplifyKernel\Config\Loader;

use ConfigTransformer202111242\Symfony\Component\Config\FileLocator;
use ConfigTransformer202111242\Symfony\Component\Config\Loader\DelegatingLoader;
use ConfigTransformer202111242\Symfony\Component\Config\Loader\GlobFileLoader;
use ConfigTransformer202111242\Symfony\Component\Config\Loader\LoaderResolver;
use ConfigTransformer202111242\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202111242\Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader;
use ConfigTransformer202111242\Symplify\SymplifyKernel\Contract\Config\LoaderFactoryInterface;
final class ParameterMergingLoaderFactory implements \ConfigTransformer202111242\Symplify\SymplifyKernel\Contract\Config\LoaderFactoryInterface
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     * @param string $currentWorkingDirectory
     */
    public function create($containerBuilder, $currentWorkingDirectory) : \ConfigTransformer202111242\Symfony\Component\Config\Loader\LoaderInterface
    {
        $fileLocator = new \ConfigTransformer202111242\Symfony\Component\Config\FileLocator([$currentWorkingDirectory]);
        $loaders = [new \ConfigTransformer202111242\Symfony\Component\Config\Loader\GlobFileLoader($fileLocator), new \ConfigTransformer202111242\Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader($containerBuilder, $fileLocator)];
        $loaderResolver = new \ConfigTransformer202111242\Symfony\Component\Config\Loader\LoaderResolver($loaders);
        return new \ConfigTransformer202111242\Symfony\Component\Config\Loader\DelegatingLoader($loaderResolver);
    }
}
