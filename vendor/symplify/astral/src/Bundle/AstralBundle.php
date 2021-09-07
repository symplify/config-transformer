<?php

declare (strict_types=1);
namespace ConfigTransformer202109075\Symplify\Astral\Bundle;

use ConfigTransformer202109075\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202109075\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202109075\Symplify\Astral\DependencyInjection\Extension\AstralExtension;
use ConfigTransformer202109075\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
final class AstralBundle extends \ConfigTransformer202109075\Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function build($containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer202109075\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : ?\ConfigTransformer202109075\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202109075\Symplify\Astral\DependencyInjection\Extension\AstralExtension();
    }
}
