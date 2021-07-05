<?php

declare (strict_types=1);
namespace ConfigTransformer202107055\Symplify\ConsolePackageBuilder\Bundle;

use ConfigTransformer202107055\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202107055\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202107055\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \ConfigTransformer202107055\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\ConfigTransformer202107055\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer202107055\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}