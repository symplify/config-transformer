<?php

declare (strict_types=1);
namespace ConfigTransformer202205121\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202205121\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202205121\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202205121\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202205121\Symfony\Component\Config\Loader\LoaderInterface;
}
