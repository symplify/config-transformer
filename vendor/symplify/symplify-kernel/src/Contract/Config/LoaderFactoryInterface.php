<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202310\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformerPrefix202310\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformerPrefix202310\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : LoaderInterface;
}
