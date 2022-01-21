<?php

declare (strict_types=1);
namespace ConfigTransformer202201211\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202201211\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202201211\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202201211\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202201211\Symfony\Component\Config\Loader\LoaderInterface;
}
