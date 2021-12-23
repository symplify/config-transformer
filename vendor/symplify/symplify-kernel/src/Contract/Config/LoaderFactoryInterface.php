<?php

declare (strict_types=1);
namespace ConfigTransformer2021122310\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer2021122310\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer2021122310\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer2021122310\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer2021122310\Symfony\Component\Config\Loader\LoaderInterface;
}
