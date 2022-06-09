<?php

declare (strict_types=1);
namespace ConfigTransformer20220609\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer20220609\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer20220609\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : LoaderInterface;
}
