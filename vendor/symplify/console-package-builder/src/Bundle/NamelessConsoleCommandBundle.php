<?php

declare (strict_types=1);
namespace ConfigTransformer202108202\Symplify\ConsolePackageBuilder\Bundle;

use ConfigTransformer202108202\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202108202\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202108202\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \ConfigTransformer202108202\Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function build($containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer202108202\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}
