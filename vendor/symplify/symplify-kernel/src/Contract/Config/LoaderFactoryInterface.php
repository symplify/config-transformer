<?php

declare (strict_types=1);
namespace ConfigTransformer202201021\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202201021\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202201021\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202201021\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202201021\Symfony\Component\Config\Loader\LoaderInterface;
}
