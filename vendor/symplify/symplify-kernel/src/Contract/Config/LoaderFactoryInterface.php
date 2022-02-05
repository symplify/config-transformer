<?php

declare (strict_types=1);
namespace ConfigTransformer202202050\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202202050\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202202050\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202202050\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202202050\Symfony\Component\Config\Loader\LoaderInterface;
}
