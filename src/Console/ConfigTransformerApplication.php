<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Console;

use ConfigTransformerPrefix202501\Symfony\Component\Console\Application;
use ConfigTransformerPrefix202501\Symfony\Component\Console\Input\InputDefinition;
use Symplify\ConfigTransformer\Console\Command\SwitchFormatCommand;
final class ConfigTransformerApplication extends Application
{
    public function __construct(SwitchFormatCommand $switchFormatCommand)
    {
        // must be run before adding commands
        // otherwise the default command will be overridden to a "list" command
        parent::__construct();
        $this->add($switchFormatCommand);
        // hide unnecesary command
        $this->get('help')->setHidden();
        $this->get('completion')->setHidden();
        // make single command application for fast run
        $this->setDefaultCommand($switchFormatCommand->getName(), \true);
    }
    protected function getDefaultInputDefinition() : InputDefinition
    {
        $defaultInputDefinition = parent::getDefaultInputDefinition();
        $options = $defaultInputDefinition->getOptions();
        // allow using -n as --dry-run alias
        unset($options['quiet'], $options['no-interaction']);
        $defaultInputDefinition->setOptions($options);
        return $defaultInputDefinition;
    }
}
