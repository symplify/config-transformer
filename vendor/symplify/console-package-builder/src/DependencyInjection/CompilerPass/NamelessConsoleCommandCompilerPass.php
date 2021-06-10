<?php

declare (strict_types=1);
namespace ConfigTransformer20210610\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass;

use ConfigTransformer20210610\Symfony\Component\Console\Command\Command;
use ConfigTransformer20210610\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ConfigTransformer20210610\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer20210610\Symplify\PackageBuilder\Console\Command\CommandNaming;
/**
 * @see \Symplify\ConsolePackageBuilder\Tests\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPassTest
 */
final class NamelessConsoleCommandCompilerPass implements \ConfigTransformer20210610\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    public function process(\ConfigTransformer20210610\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        foreach ($containerBuilder->getDefinitions() as $definition) {
            $definitionClass = $definition->getClass();
            if ($definitionClass === null) {
                continue;
            }
            if (!\is_a($definitionClass, \ConfigTransformer20210610\Symfony\Component\Console\Command\Command::class, \true)) {
                continue;
            }
            $commandName = \ConfigTransformer20210610\Symplify\PackageBuilder\Console\Command\CommandNaming::classToName($definitionClass);
            $definition->addMethodCall('setName', [$commandName]);
        }
    }
}
