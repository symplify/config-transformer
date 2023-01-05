<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202301\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202301\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : LoaderInterface;
}
