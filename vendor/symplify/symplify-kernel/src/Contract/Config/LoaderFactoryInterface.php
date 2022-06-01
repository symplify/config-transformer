<?php

declare (strict_types=1);
namespace ConfigTransformer202206010\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202206010\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202206010\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202206010\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202206010\Symfony\Component\Config\Loader\LoaderInterface;
}
