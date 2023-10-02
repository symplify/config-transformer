<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\DependencyInjection\LoaderFactory;

use ConfigTransformerPrefix202310\Symfony\Component\Config\FileLocator;
use ConfigTransformerPrefix202310\Symfony\Component\DependencyInjection\ContainerBuilder;
use Symplify\ConfigTransformer\Collector\XmlImportCollector;
use Symplify\ConfigTransformer\DependencyInjection\Loader\IdAwareXmlFileLoader;
use Symplify\ConfigTransformer\Naming\UniqueNaming;
final class IdAwareXmlFileLoaderFactory
{
    /**
     * @readonly
     * @var \Symplify\ConfigTransformer\Naming\UniqueNaming
     */
    private $uniqueNaming;
    /**
     * @readonly
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
