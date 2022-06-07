<?php

declare (strict_types=1);
namespace ConfigTransformer202206075\Symplify\ConfigTransformer\Configuration;

use ConfigTransformer202206075\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer202206075\Symplify\ConfigTransformer\ValueObject\Configuration;
use ConfigTransformer202206075\Symplify\ConfigTransformer\ValueObject\Option;
final class ConfigurationFactory
{
    public function createFromInput(InputInterface $input) : Configuration
    {
        $source = (array) $input->getArgument(Option::SOURCES);
        $isDryRun = \boolval($input->getOption(Option::DRY_RUN));
        return new Configuration($source, $isDryRun);
    }
}
