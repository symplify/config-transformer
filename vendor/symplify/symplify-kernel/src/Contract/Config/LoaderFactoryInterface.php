<?php

declare (strict_types=1);
namespace ConfigTransformer202112169\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202112169\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202112169\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202112169\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202112169\Symfony\Component\Config\Loader\LoaderInterface;
}
