<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\DependencyInjection\LoaderFactory;

use Migrify\ConfigTransformer\Collector\XmlImportCollector;
use Migrify\ConfigTransformer\Configuration\Configuration;
use Migrify\ConfigTransformer\DependencyInjection\Loader\IdAwareXmlFileLoader;
use Migrify\ConfigTransformer\Naming\UniqueNaming;
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

    /**
     * @var XmlImportCollector
     */
    private $xmlImportCollector;

    public function __construct(
        Configuration $configuration,
        UniqueNaming $uniqueNaming,
        XmlImportCollector $xmlImportCollector
    ) {
        $this->configuration = $configuration;
        $this->uniqueNaming = $uniqueNaming;
        $this->xmlImportCollector = $xmlImportCollector;
    }

    public function createFromContainerBuilder(ContainerBuilder $containerBuilder): IdAwareXmlFileLoader
    {
        return new IdAwareXmlFileLoader(
            $containerBuilder,
            new FileLocator(),
            $this->configuration,
            $this->uniqueNaming,
            $this->xmlImportCollector
        );
    }
}
