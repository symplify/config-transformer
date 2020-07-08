<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher;

use Migrify\ConfigTransformer\FormatSwitcher\Exception\NotImplementedYetException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\Dumper;
use Symfony\Component\DependencyInjection\Dumper\YamlDumper;

final class DumperFactory
{
    public function createFromContainerBuilderAndOutputFormat(
        ContainerBuilder $containerBuilder,
        string $outputFormat
    ): Dumper {
        $outputFormat = strtolower($outputFormat);
        if ($outputFormat === 'yaml') {
            return new YamlDumper($containerBuilder);
        }

        throw new NotImplementedYetException($outputFormat);
    }
}
