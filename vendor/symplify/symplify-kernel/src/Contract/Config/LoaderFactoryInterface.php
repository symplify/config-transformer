<?php

declare (strict_types=1);
namespace ConfigTransformer202111107\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202111107\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202111107\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     * @param string $currentWorkingDirectory
     */
    public function create($containerBuilder, $currentWorkingDirectory) : \ConfigTransformer202111107\Symfony\Component\Config\Loader\LoaderInterface;
}
