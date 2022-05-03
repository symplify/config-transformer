<?php

declare (strict_types=1);
namespace ConfigTransformer202205039\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202205039\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202205039\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202205039\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202205039\Symfony\Component\Config\Loader\LoaderInterface;
}
