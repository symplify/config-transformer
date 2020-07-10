<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher;

use Migrify\ConfigTransformer\FormatSwitcher\DependencyInjection\LoaderFactory\IdAwareXmlFileLoaderFactory;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\NotImplementedYetException;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\Format;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\FileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symplify\SmartFileSystem\SmartFileInfo;

final class ConfigLoader
{
    /**
     * @var IdAwareXmlFileLoaderFactory
     */
    private $idAwareXmlFileLoaderFactory;

    public function __construct(IdAwareXmlFileLoaderFactory $idAwareXmlFileLoaderFactory)
    {
        $this->idAwareXmlFileLoaderFactory = $idAwareXmlFileLoaderFactory;
    }

    public function createAndLoadContainerBuilderFromFileInfo(SmartFileInfo $smartFileInfo): ContainerBuilder
    {
        $containerBuilder = new ContainerBuilder();

        $loader = $this->createLoaderBySuffix($containerBuilder, $smartFileInfo->getSuffix());
        $loader->load($smartFileInfo->getRealPath());

        return $containerBuilder;
    }

    private function createLoaderBySuffix(ContainerBuilder $containerBuilder, string $suffix): FileLoader
    {
        if ($suffix === Format::XML) {
            return $this->idAwareXmlFileLoaderFactory->createFromContainerBuilder($containerBuilder);
        }

        if ($suffix === Format::YAML) {
            return new YamlFileLoader($containerBuilder, new FileLocator());
        }

        throw new NotImplementedYetException($suffix);
    }
}
