<?php

declare (strict_types=1);
namespace ConfigTransformer202202240\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202202240\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202202240\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202202240\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202202240\Symfony\Component\Config\Loader\LoaderInterface;
}
