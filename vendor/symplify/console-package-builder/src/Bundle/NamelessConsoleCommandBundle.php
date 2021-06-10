<?php

declare (strict_types=1);
namespace ConfigTransformer20210610\Symplify\ConsolePackageBuilder\Bundle;

use ConfigTransformer20210610\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer20210610\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer20210610\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \ConfigTransformer20210610\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\ConfigTransformer20210610\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer20210610\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}
