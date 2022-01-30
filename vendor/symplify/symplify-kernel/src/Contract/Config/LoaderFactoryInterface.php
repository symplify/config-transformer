<?php

declare (strict_types=1);
namespace ConfigTransformer202201309\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202201309\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202201309\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202201309\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202201309\Symfony\Component\Config\Loader\LoaderInterface;
}
