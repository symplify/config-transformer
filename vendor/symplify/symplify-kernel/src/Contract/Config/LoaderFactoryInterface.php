<?php

declare (strict_types=1);
namespace ConfigTransformer202203032\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202203032\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202203032\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202203032\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202203032\Symfony\Component\Config\Loader\LoaderInterface;
}
