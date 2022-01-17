<?php

declare (strict_types=1);
namespace ConfigTransformer202201177\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202201177\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202201177\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202201177\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202201177\Symfony\Component\Config\Loader\LoaderInterface;
}
