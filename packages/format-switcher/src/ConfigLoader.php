<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher;

use Migrify\ConfigTransformer\FormatSwitcher\DependencyInjection\LoaderFactory\IdAwareXmlFileLoaderFactory;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\NotImplementedYetException;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\Format;
use Nette\Utils\Strings;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\GlobFileLoader;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;

final class ConfigLoader
{
    /**
     * @var IdAwareXmlFileLoaderFactory
     */
    private $idAwareXmlFileLoaderFactory;

    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;

    public function __construct(IdAwareXmlFileLoaderFactory $idAwareXmlFileLoaderFactory, SmartFileSystem $smartFileSystem)
    {
        $this->idAwareXmlFileLoaderFactory = $idAwareXmlFileLoaderFactory;
        $this->smartFileSystem = $smartFileSystem;
    }

    public function createAndLoadContainerBuilderFromFileInfo(SmartFileInfo $smartFileInfo): ContainerBuilder
    {
        $containerBuilder = new ContainerBuilder();

        $loader = $this->createLoaderBySuffix($containerBuilder, $smartFileInfo->getSuffix());

        // correct old syntax of tags so we can parse it
        $content = $smartFileInfo->getContents();
        if (in_array($smartFileInfo->getSuffix(), ['yml', 'yaml'], true)) {
            $content = Strings::replace($content, '#\!php\/const\:( )?#', '!php/const ');
            if ($content !== $smartFileInfo->getContents()) {
                $this->smartFileSystem->dumpFile($smartFileInfo->getRealPath(), $content);
            }
        }

        $loader->load($smartFileInfo->getRealPath());

        return $containerBuilder;
    }

    private function createLoaderBySuffix(ContainerBuilder $containerBuilder, string $suffix): Loader
    {
        if ($suffix === Format::XML) {
            $xmlLoader = $this->idAwareXmlFileLoaderFactory->createFromContainerBuilder($containerBuilder);
            return $this->wrapToDelegatingLoader($xmlLoader, $containerBuilder);
        }

        if ($suffix === Format::YAML) {
            $yamlLoader = new YamlFileLoader($containerBuilder, new FileLocator());
            return $this->wrapToDelegatingLoader($yamlLoader, $containerBuilder);
        }

        throw new NotImplementedYetException($suffix);
    }

    private function wrapToDelegatingLoader(Loader $loader, ContainerBuilder $containerBuilder): DelegatingLoader
    {
        return new DelegatingLoader(new LoaderResolver([
            new GlobFileLoader($containerBuilder, new FileLocator()),
            new PhpFileLoader($containerBuilder, new FileLocator()),
            $loader,
        ]));
    }
}
