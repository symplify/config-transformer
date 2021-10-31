<?php

declare (strict_types=1);
namespace ConfigTransformer202110315\Symplify\ConfigTransformer\Configuration;

use ConfigTransformer202110315\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer202110315\Symplify\ConfigTransformer\ValueObject\Configuration;
use ConfigTransformer202110315\Symplify\ConfigTransformer\ValueObject\Option;
final class ConfigurationFactory
{
    public function createFromInput(\ConfigTransformer202110315\Symfony\Component\Console\Input\InputInterface $input) : \ConfigTransformer202110315\Symplify\ConfigTransformer\ValueObject\Configuration
    {
        $source = (array) $input->getArgument(\ConfigTransformer202110315\Symplify\ConfigTransformer\ValueObject\Option::SOURCES);
        $isDryRun = \boolval($input->getOption(\ConfigTransformer202110315\Symplify\ConfigTransformer\ValueObject\Option::DRY_RUN));
        return new \ConfigTransformer202110315\Symplify\ConfigTransformer\ValueObject\Configuration($source, $isDryRun);
    }
}
