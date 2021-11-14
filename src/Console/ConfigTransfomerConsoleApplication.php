<?php

declare (strict_types=1);
namespace ConfigTransformer202111145\Symplify\ConfigTransformer\Console;

use ConfigTransformer202111145\Symfony\Component\Console\Application;
use ConfigTransformer202111145\Symfony\Component\Console\Command\Command;
final class ConfigTransfomerConsoleApplication extends \ConfigTransformer202111145\Symfony\Component\Console\Application
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
