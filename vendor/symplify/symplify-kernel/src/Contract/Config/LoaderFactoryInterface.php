<?php

declare (strict_types=1);
namespace ConfigTransformer202206063\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202206063\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202206063\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202206063\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202206063\Symfony\Component\Config\Loader\LoaderInterface;
}
