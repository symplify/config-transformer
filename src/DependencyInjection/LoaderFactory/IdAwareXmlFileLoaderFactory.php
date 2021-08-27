<?php

declare (strict_types=1);
namespace ConfigTransformer202108279\Symplify\ConfigTransformer\DependencyInjection\LoaderFactory;

use ConfigTransformer202108279\Symfony\Component\Config\FileLocator;
use ConfigTransformer202108279\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202108279\Symplify\ConfigTransformer\Collector\XmlImportCollector;
use ConfigTransformer202108279\Symplify\ConfigTransformer\DependencyInjection\Loader\IdAwareXmlFileLoader;
use ConfigTransformer202108279\Symplify\ConfigTransformer\Naming\UniqueNaming;
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
    public function __construct(\ConfigTransformer202108279\Symplify\ConfigTransformer\Naming\UniqueNaming $uniqueNaming, \ConfigTransformer202108279\Symplify\ConfigTransformer\Collector\XmlImportCollector $xmlImportCollector)
    {
        $this->uniqueNaming = $uniqueNaming;
        $this->xmlImportCollector = $xmlImportCollector;
    }
    public function createFromContainerBuilder(\ConfigTransformer202108279\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : \ConfigTransformer202108279\Symplify\ConfigTransformer\DependencyInjection\Loader\IdAwareXmlFileLoader
    {
        return new \ConfigTransformer202108279\Symplify\ConfigTransformer\DependencyInjection\Loader\IdAwareXmlFileLoader($containerBuilder, new \ConfigTransformer202108279\Symfony\Component\Config\FileLocator(), $this->uniqueNaming, $this->xmlImportCollector);
    }
}
