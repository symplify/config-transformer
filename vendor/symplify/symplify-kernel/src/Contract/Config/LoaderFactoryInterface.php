<?php

declare (strict_types=1);
namespace ConfigTransformer2022041410\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer2022041410\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer2022041410\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer2022041410\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer2022041410\Symfony\Component\Config\Loader\LoaderInterface;
}
