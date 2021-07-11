<?php

declare (strict_types=1);
namespace ConfigTransformer202107118\Symplify\Astral\Bundle;

use ConfigTransformer202107118\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202107118\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202107118\Symplify\Astral\DependencyInjection\Extension\AstralExtension;
use ConfigTransformer202107118\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
final class AstralBundle extends \ConfigTransformer202107118\Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function build($containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer202107118\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : ?\ConfigTransformer202107118\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202107118\Symplify\Astral\DependencyInjection\Extension\AstralExtension();
    }
}
