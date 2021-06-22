<?php

declare (strict_types=1);
namespace ConfigTransformer2021062210\Symplify\ConsolePackageBuilder\Bundle;

use ConfigTransformer2021062210\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2021062210\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer2021062210\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \ConfigTransformer2021062210\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\ConfigTransformer2021062210\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer2021062210\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}
