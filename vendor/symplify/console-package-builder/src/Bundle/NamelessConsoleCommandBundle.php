<?php

declare (strict_types=1);
namespace ConfigTransformer20210606\Symplify\ConsolePackageBuilder\Bundle;

use ConfigTransformer20210606\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer20210606\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer20210606\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \ConfigTransformer20210606\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\ConfigTransformer20210606\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer20210606\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}
