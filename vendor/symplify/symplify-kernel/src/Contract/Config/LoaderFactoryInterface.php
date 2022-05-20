<?php

declare (strict_types=1);
namespace ConfigTransformer202205205\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202205205\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202205205\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202205205\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202205205\Symfony\Component\Config\Loader\LoaderInterface;
}
