<?php

declare (strict_types=1);
namespace ConfigTransformer202106181\Symplify\ConsolePackageBuilder\Bundle;

use ConfigTransformer202106181\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202106181\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202106181\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \ConfigTransformer202106181\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\ConfigTransformer202106181\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer202106181\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}
