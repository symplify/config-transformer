<?php

declare (strict_types=1);
namespace ConfigTransformer202202043\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202202043\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202202043\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202202043\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202202043\Symfony\Component\Config\Loader\LoaderInterface;
}
