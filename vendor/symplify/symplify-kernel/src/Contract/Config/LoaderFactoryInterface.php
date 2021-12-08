<?php

declare (strict_types=1);
namespace ConfigTransformer202112080\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202112080\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202112080\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     * @param string $currentWorkingDirectory
     */
    public function create($containerBuilder, $currentWorkingDirectory) : \ConfigTransformer202112080\Symfony\Component\Config\Loader\LoaderInterface;
}
