<?php

declare (strict_types=1);
namespace ConfigTransformer202112318\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202112318\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202112318\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202112318\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202112318\Symfony\Component\Config\Loader\LoaderInterface;
}
