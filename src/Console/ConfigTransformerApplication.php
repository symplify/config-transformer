<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Console;

use ConfigTransformer202207\Symfony\Component\Console\Application;
use Symplify\ConfigTransformer\Command\SwitchFormatCommand;
final class ConfigTransformerApplication extends Application
{
    public function __construct(SwitchFormatCommand $switchFormatCommand)
    {
        $this->addCommands([$switchFormatCommand]);
        parent::__construct();
    }
}
