<?php

declare (strict_types=1);
namespace ConfigTransformer202201250\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202201250\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202201250\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202201250\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202201250\Symfony\Component\Config\Loader\LoaderInterface;
}
