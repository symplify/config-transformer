<?php

declare (strict_types=1);
namespace ConfigTransformer2022030310\Symplify\SymplifyKernel\Config\Loader;

use ConfigTransformer2022030310\Symfony\Component\Config\FileLocator;
use ConfigTransformer2022030310\Symfony\Component\Config\Loader\DelegatingLoader;
use ConfigTransformer2022030310\Symfony\Component\Config\Loader\GlobFileLoader;
use ConfigTransformer2022030310\Symfony\Component\Config\Loader\LoaderResolver;
use ConfigTransformer2022030310\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2022030310\Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader;
use ConfigTransformer2022030310\Symplify\SymplifyKernel\Contract\Config\LoaderFactoryInterface;
final class ParameterMergingLoaderFactory implements \ConfigTransformer2022030310\Symplify\SymplifyKernel\Contract\Config\LoaderFactoryInterface
{
    public function create(\ConfigTransformer2022030310\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer2022030310\Symfony\Component\Config\Loader\LoaderInterface
    {
        $fileLocator = new \ConfigTransformer2022030310\Symfony\Component\Config\FileLocator([$currentWorkingDirectory]);
        $loaders = [new \ConfigTransformer2022030310\Symfony\Component\Config\Loader\GlobFileLoader($fileLocator), new \ConfigTransformer2022030310\Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader($containerBuilder, $fileLocator)];
        $loaderResolver = new \ConfigTransformer2022030310\Symfony\Component\Config\Loader\LoaderResolver($loaders);
        return new \ConfigTransformer2022030310\Symfony\Component\Config\Loader\DelegatingLoader($loaderResolver);
    }
}
