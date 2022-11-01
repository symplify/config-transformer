<?php

declare (strict_types=1);
namespace ConfigTransformer202211\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202211\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202211\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : LoaderInterface;
}
