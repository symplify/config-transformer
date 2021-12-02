<?php

declare (strict_types=1);
namespace ConfigTransformer2021120210\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer2021120210\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer2021120210\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     * @param string $currentWorkingDirectory
     */
    public function create($containerBuilder, $currentWorkingDirectory) : \ConfigTransformer2021120210\Symfony\Component\Config\Loader\LoaderInterface;
}
