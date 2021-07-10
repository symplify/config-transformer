<?php

declare (strict_types=1);
namespace ConfigTransformer202107102\Symplify\ConsolePackageBuilder\Bundle;

use ConfigTransformer202107102\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202107102\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202107102\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \ConfigTransformer202107102\Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function build($containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer202107102\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}
