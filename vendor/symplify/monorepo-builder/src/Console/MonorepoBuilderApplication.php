<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Console;

use ConfigTransformer202301\Symfony\Component\Console\Application;
use ConfigTransformer202301\Symfony\Component\Console\Command\Command;
final class MonorepoBuilderApplication extends Application
{
    /**
     * @param Command[] $commands
     */
    public function __construct(array $commands)
    {
        $this->addCommands($commands);
        parent::__construct();
    }
}
