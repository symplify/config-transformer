<?php

declare (strict_types=1);
namespace ConfigTransformer202203073\Symplify\ConfigTransformer\Configuration;

use ConfigTransformer202203073\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer202203073\Symplify\ConfigTransformer\ValueObject\Configuration;
use ConfigTransformer202203073\Symplify\ConfigTransformer\ValueObject\Option;
final class ConfigurationFactory
{
    public function createFromInput(\ConfigTransformer202203073\Symfony\Component\Console\Input\InputInterface $input) : \ConfigTransformer202203073\Symplify\ConfigTransformer\ValueObject\Configuration
    {
        $source = (array) $input->getArgument(\ConfigTransformer202203073\Symplify\ConfigTransformer\ValueObject\Option::SOURCES);
        $isDryRun = \boolval($input->getOption(\ConfigTransformer202203073\Symplify\ConfigTransformer\ValueObject\Option::DRY_RUN));
        return new \ConfigTransformer202203073\Symplify\ConfigTransformer\ValueObject\Configuration($source, $isDryRun);
    }
}
