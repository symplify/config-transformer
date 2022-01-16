<?php

declare (strict_types=1);
namespace ConfigTransformer202201166\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202201166\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202201166\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202201166\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202201166\Symfony\Component\Config\Loader\LoaderInterface;
}
