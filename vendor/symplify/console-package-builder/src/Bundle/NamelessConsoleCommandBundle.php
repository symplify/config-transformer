<?php

declare (strict_types=1);
namespace ConfigTransformer202110017\Symplify\ConsolePackageBuilder\Bundle;

use ConfigTransformer202110017\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202110017\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202110017\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \ConfigTransformer202110017\Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function build($containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer202110017\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}
