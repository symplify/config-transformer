<?php

declare (strict_types=1);
namespace ConfigTransformer202201244\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202201244\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202201244\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202201244\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202201244\Symfony\Component\Config\Loader\LoaderInterface;
}
