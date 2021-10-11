<?php

declare (strict_types=1);
namespace ConfigTransformer202110110\Symplify\ConfigTransformer\Console;

use ConfigTransformer202110110\Symfony\Component\Console\Application;
use ConfigTransformer202110110\Symfony\Component\Console\Command\Command;
use ConfigTransformer202110110\Symplify\PackageBuilder\Console\Command\CommandNaming;
final class ConfigTransfomerConsoleApplication extends \ConfigTransformer202110110\Symfony\Component\Console\Application
{
    /**
     * @param Command[] $commands
     */
    public function __construct(\ConfigTransformer202110110\Symplify\PackageBuilder\Console\Command\CommandNaming $commandNaming, array $commands)
    {
        foreach ($commands as $command) {
            $commandName = $commandNaming->resolveFromCommand($command);
            $command->setName($commandName);
            $this->add($command);
        }
        parent::__construct('Config Transformer');
    }
}
