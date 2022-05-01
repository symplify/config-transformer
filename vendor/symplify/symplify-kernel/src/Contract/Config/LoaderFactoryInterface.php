<?php

declare (strict_types=1);
namespace ConfigTransformer202205015\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202205015\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202205015\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202205015\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202205015\Symfony\Component\Config\Loader\LoaderInterface;
}
