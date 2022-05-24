<?php

declare (strict_types=1);
namespace ConfigTransformer2022052410\Symplify\ConfigTransformer\DependencyInjection\LoaderFactory;

use ConfigTransformer2022052410\Symfony\Component\Config\FileLocator;
use ConfigTransformer2022052410\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2022052410\Symplify\ConfigTransformer\Collector\XmlImportCollector;
use ConfigTransformer2022052410\Symplify\ConfigTransformer\DependencyInjection\Loader\IdAwareXmlFileLoader;
use ConfigTransformer2022052410\Symplify\ConfigTransformer\Naming\UniqueNaming;
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
    public function __construct(\ConfigTransformer2022052410\Symplify\ConfigTransformer\Naming\UniqueNaming $uniqueNaming, \ConfigTransformer2022052410\Symplify\ConfigTransformer\Collector\XmlImportCollector $xmlImportCollector)
    {
        $this->uniqueNaming = $uniqueNaming;
        $this->xmlImportCollector = $xmlImportCollector;
    }
    public function createFromContainerBuilder(\ConfigTransformer2022052410\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : \ConfigTransformer2022052410\Symplify\ConfigTransformer\DependencyInjection\Loader\IdAwareXmlFileLoader
    {
        return new \ConfigTransformer2022052410\Symplify\ConfigTransformer\DependencyInjection\Loader\IdAwareXmlFileLoader($containerBuilder, new \ConfigTransformer2022052410\Symfony\Component\Config\FileLocator(), $this->uniqueNaming, $this->xmlImportCollector);
    }
}
