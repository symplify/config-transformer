<?php

declare (strict_types=1);
namespace ConfigTransformer202205129\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202205129\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202205129\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202205129\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202205129\Symfony\Component\Config\Loader\LoaderInterface;
}
