<?php

declare (strict_types=1);
namespace ConfigTransformer202202152\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202202152\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202202152\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202202152\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202202152\Symfony\Component\Config\Loader\LoaderInterface;
}
