<?php

declare (strict_types=1);
namespace ConfigTransformer202108096\Symplify\ConfigTransformer\Console;

use ConfigTransformer202108096\Symfony\Component\Console\Application;
use ConfigTransformer202108096\Symfony\Component\Console\Command\Command;
use ConfigTransformer202108096\Symplify\PackageBuilder\Console\Command\CommandNaming;
final class ConfigTransfomerConsoleApplication extends \ConfigTransformer202108096\Symfony\Component\Console\Application
{
    /**
     * @param Command[] $commands
     */
    public function __construct(\ConfigTransformer202108096\Symplify\PackageBuilder\Console\Command\CommandNaming $commandNaming, array $commands)
    {
        foreach ($commands as $command) {
            $commandName = $commandNaming->resolveFromCommand($command);
            $command->setName($commandName);
            $this->add($command);
        }
        parent::__construct('Config Transformer');
    }
}
