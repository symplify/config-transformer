<?php

declare (strict_types=1);
namespace ConfigTransformer2022022110\Symplify\ConfigTransformer\Configuration;

use ConfigTransformer2022022110\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer2022022110\Symplify\ConfigTransformer\ValueObject\Configuration;
use ConfigTransformer2022022110\Symplify\ConfigTransformer\ValueObject\Option;
final class ConfigurationFactory
{
    public function createFromInput(\ConfigTransformer2022022110\Symfony\Component\Console\Input\InputInterface $input) : \ConfigTransformer2022022110\Symplify\ConfigTransformer\ValueObject\Configuration
    {
        $source = (array) $input->getArgument(\ConfigTransformer2022022110\Symplify\ConfigTransformer\ValueObject\Option::SOURCES);
        $isDryRun = \boolval($input->getOption(\ConfigTransformer2022022110\Symplify\ConfigTransformer\ValueObject\Option::DRY_RUN));
        return new \ConfigTransformer2022022110\Symplify\ConfigTransformer\ValueObject\Configuration($source, $isDryRun);
    }
}
