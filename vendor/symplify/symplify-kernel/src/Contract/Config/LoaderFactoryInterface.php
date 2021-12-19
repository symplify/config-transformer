<?php

declare (strict_types=1);
namespace ConfigTransformer202112190\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202112190\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202112190\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202112190\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202112190\Symfony\Component\Config\Loader\LoaderInterface;
}
