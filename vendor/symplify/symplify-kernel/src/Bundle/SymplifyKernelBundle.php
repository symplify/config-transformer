<?php

declare (strict_types=1);
namespace ConfigTransformer2021062210\Symplify\SymplifyKernel\Bundle;

use ConfigTransformer2021062210\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2021062210\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer2021062210\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use ConfigTransformer2021062210\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension;
final class SymplifyKernelBundle extends \ConfigTransformer2021062210\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\ConfigTransformer2021062210\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer2021062210\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : ?\ConfigTransformer2021062210\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer2021062210\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension();
    }
}
