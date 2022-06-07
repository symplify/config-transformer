<?php

declare (strict_types=1);
namespace ConfigTransformer202206075\Symplify\ConfigTransformer\DependencyInjection\LoaderFactory;

use ConfigTransformer202206075\Symfony\Component\Config\FileLocator;
use ConfigTransformer202206075\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202206075\Symplify\ConfigTransformer\Collector\XmlImportCollector;
use ConfigTransformer202206075\Symplify\ConfigTransformer\DependencyInjection\Loader\IdAwareXmlFileLoader;
use ConfigTransformer202206075\Symplify\ConfigTransformer\Naming\UniqueNaming;
final class IdAwareXmlFileLoaderFactory
{
    /**
     * @var \Symplify\ConfigTransformer\Naming\UniqueNaming
     */
    private $uniqueNaming;
    /**
     * @var \Symplify\ConfigTransformer\Collector\XmlImportCollector
     */
    private $xmlImportCollector;
    public function __construct(UniqueNaming $uniqueNaming, XmlImportCollector $xmlImportCollector)
    {
        $this->uniqueNaming = $uniqueNaming;
        $this->xmlImportCollector = $xmlImportCollector;
    }
    public function createFromContainerBuilder(ContainerBuilder $containerBuilder) : IdAwareXmlFileLoader
    {
        return new IdAwareXmlFileLoader($containerBuilder, new FileLocator(), $this->uniqueNaming, $this->xmlImportCollector);
    }
}
