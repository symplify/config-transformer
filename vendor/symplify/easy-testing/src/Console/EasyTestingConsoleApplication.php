<?php

declare (strict_types=1);
namespace ConfigTransformer202110017\Symplify\EasyTesting\Console;

use ConfigTransformer202110017\Symfony\Component\Console\Application;
use ConfigTransformer202110017\Symfony\Component\Console\Command\Command;
use ConfigTransformer202110017\Symplify\PackageBuilder\Console\Command\CommandNaming;
final class EasyTestingConsoleApplication extends \ConfigTransformer202110017\Symfony\Component\Console\Application
{
    /**
     * @param Command[] $commands
     */
    public function __construct(\ConfigTransformer202110017\Symplify\PackageBuilder\Console\Command\CommandNaming $commandNaming, array $commands)
    {
        foreach ($commands as $command) {
            $commandName = $commandNaming->resolveFromCommand($command);
            $command->setName($commandName);
            $this->add($command);
        }
        parent::__construct('Easy Testing');
    }
}
