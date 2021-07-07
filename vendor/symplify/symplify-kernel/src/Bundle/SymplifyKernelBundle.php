<?php

declare (strict_types=1);
namespace ConfigTransformer202107076\Symplify\SymplifyKernel\Bundle;

use ConfigTransformer202107076\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202107076\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202107076\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use ConfigTransformer202107076\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension;
final class SymplifyKernelBundle extends \ConfigTransformer202107076\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\ConfigTransformer202107076\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer202107076\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : ?\ConfigTransformer202107076\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202107076\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension();
    }
}
