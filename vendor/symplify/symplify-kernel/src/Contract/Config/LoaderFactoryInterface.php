<?php

declare (strict_types=1);
namespace ConfigTransformer202207\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202207\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202207\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : LoaderInterface;
}
