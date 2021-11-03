<?php

declare (strict_types=1);
namespace ConfigTransformer2021110310\Symplify\ConfigTransformer\Console;

use ConfigTransformer2021110310\Symfony\Component\Console\Application;
use ConfigTransformer2021110310\Symfony\Component\Console\Command\Command;
final class ConfigTransfomerConsoleApplication extends \ConfigTransformer2021110310\Symfony\Component\Console\Application
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
