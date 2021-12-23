<?php

declare (strict_types=1);
namespace ConfigTransformer202112238\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202112238\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202112238\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202112238\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202112238\Symfony\Component\Config\Loader\LoaderInterface;
}
