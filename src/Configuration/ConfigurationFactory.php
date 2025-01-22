<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Configuration;

use ConfigTransformerPrefix202501\Symfony\Component\Console\Input\InputInterface;
use Symplify\ConfigTransformer\ValueObject\Configuration;
use Symplify\ConfigTransformer\ValueObject\Option;
final class ConfigurationFactory
{
    public function createFromInput(InputInterface $input) : Configuration
    {
        $source = (array) $input->getArgument(Option::SOURCES);
        $isDryRun = (bool) $input->getOption(Option::DRY_RUN);
        $areRoutesIncluded = !$input->getOption(Option::SKIP_ROUTES);
        return new Configuration($source, $isDryRun, $areRoutesIncluded);
    }
}
