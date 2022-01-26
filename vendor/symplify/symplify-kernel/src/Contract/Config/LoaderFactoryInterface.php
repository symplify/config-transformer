<?php

declare (strict_types=1);
namespace ConfigTransformer202201264\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202201264\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202201264\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202201264\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202201264\Symfony\Component\Config\Loader\LoaderInterface;
}
