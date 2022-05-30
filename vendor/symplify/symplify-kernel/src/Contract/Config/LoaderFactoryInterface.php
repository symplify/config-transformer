<?php

declare (strict_types=1);
namespace ConfigTransformer202205306\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202205306\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202205306\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202205306\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202205306\Symfony\Component\Config\Loader\LoaderInterface;
}
