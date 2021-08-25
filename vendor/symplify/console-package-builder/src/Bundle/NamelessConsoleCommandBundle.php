<?php

declare (strict_types=1);
namespace ConfigTransformer2021082510\Symplify\ConsolePackageBuilder\Bundle;

use ConfigTransformer2021082510\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2021082510\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer2021082510\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass;
final class NamelessConsoleCommandBundle extends \ConfigTransformer2021082510\Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function build($containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \ConfigTransformer2021082510\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPass());
    }
}
