<?php

declare (strict_types=1);
namespace ConfigTransformer202107075\Symplify\ConsolePackageBuilder\Bundle;

use ConfigTransformer202107075\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202107075\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202107075\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \ConfigTransformer202107075\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\ConfigTransformer202107075\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer202107075\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}
