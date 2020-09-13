<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\DependencyInjection\LoaderFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Configuration\Configuration;
use Migrify\ConfigTransformer\FormatSwitcher\DependencyInjection\Loader\IdAwareXmlFileLoader;
use Migrify\ConfigTransformer\FormatSwitcher\Naming\UniqueNaming;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class IdAwareXmlFileLoaderFactory
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var UniqueNaming
     */
    private $uniqueNaming;

    public function __construct(Configuration $configuration, UniqueNaming $uniqueNaming)
    {
        $this->configuration = $configuration;
        $this->uniqueNaming = $uniqueNaming;
    }

    public function createFromContainerBuilder(ContainerBuilder $containerBuilder): IdAwareXmlFileLoader
    {
        return new IdAwareXmlFileLoader(
            $containerBuilder,
            new FileLocator(),
            $this->configuration,
            $this->uniqueNaming
        );
    }
}
