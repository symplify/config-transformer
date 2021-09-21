<?php

declare (strict_types=1);
namespace ConfigTransformer202109212\Symplify\ConsolePackageBuilder\Bundle;

use ConfigTransformer202109212\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202109212\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202109212\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \ConfigTransformer202109212\Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function build($containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer202109212\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}
