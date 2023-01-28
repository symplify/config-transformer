<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202301\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformerPrefix202301\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformerPrefix202301\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : LoaderInterface;
}
