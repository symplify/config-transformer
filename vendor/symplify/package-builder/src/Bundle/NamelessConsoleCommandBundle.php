<?php

declare (strict_types=1);
namespace ConfigTransformer202111019\Symplify\PackageBuilder\Bundle;

use ConfigTransformer202111019\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202111019\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202111019\Symplify\PackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \ConfigTransformer202111019\Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function build($containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer202111019\Symplify\PackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}
