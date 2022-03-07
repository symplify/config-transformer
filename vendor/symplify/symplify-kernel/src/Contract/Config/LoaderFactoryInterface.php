<?php

declare (strict_types=1);
namespace ConfigTransformer202203075\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202203075\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202203075\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202203075\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202203075\Symfony\Component\Config\Loader\LoaderInterface;
}
