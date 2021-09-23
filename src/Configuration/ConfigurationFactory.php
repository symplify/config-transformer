<?php

declare (strict_types=1);
namespace ConfigTransformer202109235\Symplify\ConfigTransformer\Configuration;

use ConfigTransformer202109235\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer202109235\Symplify\ConfigTransformer\ValueObject\Configuration;
use ConfigTransformer202109235\Symplify\ConfigTransformer\ValueObject\Option;
final class ConfigurationFactory
{
    public function createFromInput(\ConfigTransformer202109235\Symfony\Component\Console\Input\InputInterface $input) : \ConfigTransformer202109235\Symplify\ConfigTransformer\ValueObject\Configuration
    {
        $source = (array) $input->getArgument(\ConfigTransformer202109235\Symplify\ConfigTransformer\ValueObject\Option::SOURCES);
        $targetSymfonyVersion = \floatval($input->getOption(\ConfigTransformer202109235\Symplify\ConfigTransformer\ValueObject\Option::TARGET_SYMFONY_VERSION));
        $isDryRun = \boolval($input->getOption(\ConfigTransformer202109235\Symplify\ConfigTransformer\ValueObject\Option::DRY_RUN));
        return new \ConfigTransformer202109235\Symplify\ConfigTransformer\ValueObject\Configuration($source, $targetSymfonyVersion, $isDryRun);
    }
}
