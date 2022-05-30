<?php

declare (strict_types=1);
namespace ConfigTransformer202205308\Symplify\ConfigTransformer\Configuration;

use ConfigTransformer202205308\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer202205308\Symplify\ConfigTransformer\ValueObject\Configuration;
use ConfigTransformer202205308\Symplify\ConfigTransformer\ValueObject\Option;
final class ConfigurationFactory
{
    public function createFromInput(\ConfigTransformer202205308\Symfony\Component\Console\Input\InputInterface $input) : \ConfigTransformer202205308\Symplify\ConfigTransformer\ValueObject\Configuration
    {
        $source = (array) $input->getArgument(\ConfigTransformer202205308\Symplify\ConfigTransformer\ValueObject\Option::SOURCES);
        $isDryRun = \boolval($input->getOption(\ConfigTransformer202205308\Symplify\ConfigTransformer\ValueObject\Option::DRY_RUN));
        return new \ConfigTransformer202205308\Symplify\ConfigTransformer\ValueObject\Configuration($source, $isDryRun);
    }
}
