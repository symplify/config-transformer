<?php

declare (strict_types=1);
namespace ConfigTransformer2021123110\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer2021123110\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer2021123110\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer2021123110\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer2021123110\Symfony\Component\Config\Loader\LoaderInterface;
}
