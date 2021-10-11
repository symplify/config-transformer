<?php

declare (strict_types=1);
namespace ConfigTransformer2021101110\Symplify\Astral\Bundle;

use ConfigTransformer2021101110\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2021101110\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer2021101110\Symplify\Astral\DependencyInjection\Extension\AstralExtension;
use ConfigTransformer2021101110\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
final class AstralBundle extends \ConfigTransformer2021101110\Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function build($containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer2021101110\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : ?\ConfigTransformer2021101110\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer2021101110\Symplify\Astral\DependencyInjection\Extension\AstralExtension();
    }
}
