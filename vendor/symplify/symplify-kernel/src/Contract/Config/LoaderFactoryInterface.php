<?php

declare (strict_types=1);
namespace ConfigTransformer2022030710\Symplify\SymplifyKernel\Contract\Config;

use ConfigTransformer2022030710\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer2022030710\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\ConfigTransformer2022030710\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer2022030710\Symfony\Component\Config\Loader\LoaderInterface;
}
