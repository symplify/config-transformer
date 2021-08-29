<?php

declare (strict_types=1);
namespace ConfigTransformer202108297\Symplify\Astral\Bundle;

use ConfigTransformer202108297\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202108297\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202108297\Symplify\Astral\DependencyInjection\Extension\AstralExtension;
use ConfigTransformer202108297\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
final class AstralBundle extends \ConfigTransformer202108297\Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function build($containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer202108297\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : ?\ConfigTransformer202108297\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202108297\Symplify\Astral\DependencyInjection\Extension\AstralExtension();
    }
}
