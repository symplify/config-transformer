<?php

declare (strict_types=1);
namespace ConfigTransformer202209\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202209\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202209\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : LoaderInterface;
}
