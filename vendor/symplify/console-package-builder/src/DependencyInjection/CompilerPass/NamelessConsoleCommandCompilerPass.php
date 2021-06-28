<?php

declare (strict_types=1);
namespace ConfigTransformer202106289\Symplify\ConsolePackageBuilder\DependencyInjection\CompilerPass;

use ConfigTransformer202106289\Symfony\Component\Console\Command\Command;
use ConfigTransformer202106289\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ConfigTransformer202106289\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202106289\Symplify\PackageBuilder\Console\Command\CommandNaming;
/**
 * @see \Symplify\ConsolePackageBuilder\Tests\DependencyInjection\CompilerPass\NamelessConsoleCommandCompilerPassTest
 */
final class NamelessConsoleCommandCompilerPass implements \ConfigTransformer202106289\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    public function process(\ConfigTransformer202106289\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        foreach ($containerBuilder->getDefinitions() as $definition) {
            $definitionClass = $definition->getClass();
            if ($definitionClass === null) {
                continue;
            }
            if (!\is_a($definitionClass, \ConfigTransformer202106289\Symfony\Component\Console\Command\Command::class, \true)) {
                continue;
            }
            $commandName = \ConfigTransformer202106289\Symplify\PackageBuilder\Console\Command\CommandNaming::classToName($definitionClass);
            $definition->addMethodCall('setName', [$commandName]);
        }
    }
}
