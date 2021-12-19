<?php

declare (strict_types=1);
namespace ConfigTransformer202112193\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202112193\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202112193\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202112193\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202112193\Symfony\Component\Config\Loader\LoaderInterface;
}
