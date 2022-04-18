<?php

declare (strict_types=1);
namespace ConfigTransformer202204188\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer202204188\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202204188\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer202204188\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202204188\Symfony\Component\Config\Loader\LoaderInterface;
}
