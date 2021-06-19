<?php

declare (strict_types=1);
namespace ConfigTransformer202106199\Symplify\Astral\Bundle;

use ConfigTransformer202106199\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202106199\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202106199\Symplify\Astral\DependencyInjection\Extension\AstralExtension;
use ConfigTransformer202106199\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
final class AstralBundle extends \ConfigTransformer202106199\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\ConfigTransformer202106199\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer202106199\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : ?\ConfigTransformer202106199\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202106199\Symplify\Astral\DependencyInjection\Extension\AstralExtension();
    }
}
