<?php

declare (strict_types=1);
namespace ConfigTransformer2021061110\Symplify\Astral\Bundle;

use ConfigTransformer2021061110\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2021061110\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer2021061110\Symplify\Astral\DependencyInjection\Extension\AstralExtension;
use ConfigTransformer2021061110\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
final class AstralBundle extends \ConfigTransformer2021061110\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\ConfigTransformer2021061110\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer2021061110\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : ?\ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer2021061110\Symplify\Astral\DependencyInjection\Extension\AstralExtension();
    }
}
