<?php

declare (strict_types=1);
namespace ConfigTransformer202205170\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202205170\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202205170\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202205170\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202205170\Symfony\Component\Config\Loader\LoaderInterface;
}
