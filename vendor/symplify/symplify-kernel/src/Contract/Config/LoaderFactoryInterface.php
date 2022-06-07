<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer2022060710\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer2022060710\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : LoaderInterface;
}
