<?php

declare (strict_types=1);
namespace ConfigTransformer2021072110\Symplify\ConfigTransformer\DependencyInjection\LoaderFactory;

use ConfigTransformer2021072110\Symfony\Component\Config\FileLocator;
use ConfigTransformer2021072110\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2021072110\Symplify\ConfigTransformer\Collector\XmlImportCollector;
use ConfigTransformer2021072110\Symplify\ConfigTransformer\Configuration\Configuration;
use ConfigTransformer2021072110\Symplify\ConfigTransformer\DependencyInjection\Loader\IdAwareXmlFileLoader;
use ConfigTransformer2021072110\Symplify\ConfigTransformer\Naming\UniqueNaming;
final class IdAwareXmlFileLoaderFactory
{
    /**
     * @var \Symplify\ConfigTransformer\Configuration\Configuration
     */
    private $configuration;
    /**
     * @var \Symplify\ConfigTransformer\Naming\UniqueNaming
     */
    private $uniqueNaming;
    /**
     * @var \Symplify\ConfigTransformer\Collector\XmlImportCollector
     */
    private $xmlImportCollector;
    public function __construct(\ConfigTransformer2021072110\Symplify\ConfigTransformer\Configuration\Configuration $configuration, \ConfigTransformer2021072110\Symplify\ConfigTransformer\Naming\UniqueNaming $uniqueNaming, \ConfigTransformer2021072110\Symplify\ConfigTransformer\Collector\XmlImportCollector $xmlImportCollector)
    {
        $this->configuration = $configuration;
        $this->uniqueNaming = $uniqueNaming;
        $this->xmlImportCollector = $xmlImportCollector;
    }
    public function createFromContainerBuilder(\ConfigTransformer2021072110\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : \ConfigTransformer2021072110\Symplify\ConfigTransformer\DependencyInjection\Loader\IdAwareXmlFileLoader
    {
        return new \ConfigTransformer2021072110\Symplify\ConfigTransformer\DependencyInjection\Loader\IdAwareXmlFileLoader($containerBuilder, new \ConfigTransformer2021072110\Symfony\Component\Config\FileLocator(), $this->configuration, $this->uniqueNaming, $this->xmlImportCollector);
    }
}
