<?php

declare (strict_types=1);
namespace ConfigTransformer202202198\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202202198\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202202198\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202202198\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202202198\Symfony\Component\Config\Loader\LoaderInterface;
}
