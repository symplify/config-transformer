<?php

declare (strict_types=1);
namespace ConfigTransformer202202152\Symplify\ConfigTransformer\DependencyInjection\LoaderFactory;

use ConfigTransformer202202152\Symfony\Component\Config\FileLocator;
use ConfigTransformer202202152\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202202152\Symplify\ConfigTransformer\Collector\XmlImportCollector;
use ConfigTransformer202202152\Symplify\ConfigTransformer\DependencyInjection\Loader\IdAwareXmlFileLoader;
use ConfigTransformer202202152\Symplify\ConfigTransformer\Naming\UniqueNaming;
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
    public function __construct(\ConfigTransformer202202152\Symplify\ConfigTransformer\Naming\UniqueNaming $uniqueNaming, \ConfigTransformer202202152\Symplify\ConfigTransformer\Collector\XmlImportCollector $xmlImportCollector)
    {
        $this->uniqueNaming = $uniqueNaming;
        $this->xmlImportCollector = $xmlImportCollector;
    }
    public function createFromContainerBuilder(\ConfigTransformer202202152\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : \ConfigTransformer202202152\Symplify\ConfigTransformer\DependencyInjection\Loader\IdAwareXmlFileLoader
    {
        return new \ConfigTransformer202202152\Symplify\ConfigTransformer\DependencyInjection\Loader\IdAwareXmlFileLoader($containerBuilder, new \ConfigTransformer202202152\Symfony\Component\Config\FileLocator(), $this->uniqueNaming, $this->xmlImportCollector);
    }
}
