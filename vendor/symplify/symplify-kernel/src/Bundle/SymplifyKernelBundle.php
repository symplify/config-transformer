<?php

declare (strict_types=1);
namespace ConfigTransformer202109063\Symplify\SymplifyKernel\Bundle;

use ConfigTransformer202109063\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202109063\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202109063\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use ConfigTransformer202109063\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension;
final class SymplifyKernelBundle extends \ConfigTransformer202109063\Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function build($containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer202109063\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : ?\ConfigTransformer202109063\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202109063\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension();
    }
}
