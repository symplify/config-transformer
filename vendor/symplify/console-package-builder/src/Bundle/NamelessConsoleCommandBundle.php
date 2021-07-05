<?php

declare (strict_types=1);
namespace ConfigTransformer202107058\Symplify\ConsolePackageBuilder\Bundle;

use ConfigTransformer202107058\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202107058\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202107058\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \ConfigTransformer202107058\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\ConfigTransformer202107058\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer202107058\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}
