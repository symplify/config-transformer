<?php

declare (strict_types=1);
namespace ConfigTransformer202205127\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202205127\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202205127\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202205127\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202205127\Symfony\Component\Config\Loader\LoaderInterface;
}
