<?php

declare (strict_types=1);
namespace ConfigTransformer20210610\Symplify\SymplifyKernel\Bundle;

use ConfigTransformer20210610\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer20210610\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer20210610\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use ConfigTransformer20210610\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension;
final class SymplifyKernelBundle extends \ConfigTransformer20210610\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\ConfigTransformer20210610\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer20210610\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : ?\ConfigTransformer20210610\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer20210610\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension();
    }
}
