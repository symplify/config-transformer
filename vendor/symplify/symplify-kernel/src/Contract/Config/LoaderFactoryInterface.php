<?php

declare (strict_types=1);
namespace ConfigTransformer202206052\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202206052\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202206052\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202206052\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202206052\Symfony\Component\Config\Loader\LoaderInterface;
}
