<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher;

use Migrify\ConfigTransformer\FormatSwitcher\DependencyInjection\Loader\IdAwareXmlFileLoader;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\NotImplementedYetException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\FileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symplify\SmartFileSystem\SmartFileInfo;

final class ConfigLoader
{
    public function createAndLoadContainerBuilderFromFileInfo(SmartFileInfo $smartFileInfo): ContainerBuilder
    {
        $containerBuilder = new ContainerBuilder();

        $loader = $this->createLoaderBySuffix($containerBuilder, $smartFileInfo->getSuffix());
        $loader->load($smartFileInfo->getRealPath());

        return $containerBuilder;
    }

    private function createLoaderBySuffix(ContainerBuilder $containerBuilder, string $suffix): FileLoader
    {
        if ($suffix === 'xml') {
            return new IdAwareXmlFileLoader($containerBuilder, new FileLocator());
        }

        if ($suffix === 'yaml') {
            return new YamlFileLoader($containerBuilder, new FileLocator());
        }

        throw new NotImplementedYetException($suffix);
    }
}
