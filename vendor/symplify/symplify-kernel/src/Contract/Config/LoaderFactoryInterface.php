<?php

declare (strict_types=1);
namespace ConfigTransformer202201257\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202201257\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202201257\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202201257\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202201257\Symfony\Component\Config\Loader\LoaderInterface;
}
