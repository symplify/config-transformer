<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Console;

use ConfigTransformerPrefix202302\Symfony\Component\Console\Application;
use Symplify\ConfigTransformer\Command\SwitchFormatCommand;
final class ConfigTransformerApplication extends Application
{
    public function __construct(SwitchFormatCommand $switchFormatCommand)
    {
        // must be run before adding commands
        // otherwise the default command will be overridden to a "list" command
        parent::__construct();
        $this->add($switchFormatCommand);
        // make single command application
        $this->setDefaultCommand($switchFormatCommand->getName(), \true);
    }
}
