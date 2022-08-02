<?php

declare (strict_types=1);
namespace ConfigTransformer202208\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202208\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202208\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : LoaderInterface;
}
