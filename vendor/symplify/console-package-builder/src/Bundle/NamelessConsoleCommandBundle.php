<?php

declare (strict_types=1);
namespace ConfigTransformer2021070510\Symplify\ConsolePackageBuilder\Bundle;

use ConfigTransformer2021070510\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2021070510\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer2021070510\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \ConfigTransformer2021070510\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\ConfigTransformer2021070510\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer2021070510\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}
