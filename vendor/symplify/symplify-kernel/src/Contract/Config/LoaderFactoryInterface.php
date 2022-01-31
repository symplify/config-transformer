<?php

declare (strict_types=1);
namespace ConfigTransformer202201311\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202201311\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202201311\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202201311\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202201311\Symfony\Component\Config\Loader\LoaderInterface;
}
