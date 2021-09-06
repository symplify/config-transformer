<?php

declare (strict_types=1);
namespace ConfigTransformer202109067\Symplify\EasyTesting\Console;

use ConfigTransformer202109067\Symfony\Component\Console\Application;
use ConfigTransformer202109067\Symfony\Component\Console\Command\Command;
use ConfigTransformer202109067\Symplify\PackageBuilder\Console\Command\CommandNaming;
final class EasyTestingConsoleApplication extends \ConfigTransformer202109067\Symfony\Component\Console\Application
{
    /**
     * @param Command[] $commands
     */
    public function __construct(\ConfigTransformer202109067\Symplify\PackageBuilder\Console\Command\CommandNaming $commandNaming, array $commands)
    {
        foreach ($commands as $command) {
            $commandName = $commandNaming->resolveFromCommand($command);
            $command->setName($commandName);
            $this->add($command);
        }
        parent::__construct('Easy Testing');
    }
}
