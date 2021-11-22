<?php

declare (strict_types=1);
namespace ConfigTransformer2021112210\Symplify\ConfigTransformer\Console;

use ConfigTransformer2021112210\Symfony\Component\Console\Application;
use ConfigTransformer2021112210\Symfony\Component\Console\Command\Command;
final class ConfigTransfomerConsoleApplication extends \ConfigTransformer2021112210\Symfony\Component\Console\Application
{
    /**
     * @param Command[] $commands
     */
    public function __construct(array $commands)
    {
        parent::__construct('Config Transformer');
        $this->addCommands($commands);
    }
}
