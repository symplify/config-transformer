<?php

declare (strict_types=1);
namespace ConfigTransformer202202180\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202202180\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202202180\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202202180\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202202180\Symfony\Component\Config\Loader\LoaderInterface;
}
