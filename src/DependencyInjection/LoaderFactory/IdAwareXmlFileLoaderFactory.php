<?php

declare (strict_types=1);
namespace ConfigTransformer20210604\Symplify\ConfigTransformer\DependencyInjection\LoaderFactory;

use ConfigTransformer20210604\Symfony\Component\Config\FileLocator;
use ConfigTransformer20210604\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer20210604\Symplify\ConfigTransformer\Collector\XmlImportCollector;
use ConfigTransformer20210604\Symplify\ConfigTransformer\Configuration\Configuration;
use ConfigTransformer20210604\Symplify\ConfigTransformer\DependencyInjection\Loader\IdAwareXmlFileLoader;
use ConfigTransformer20210604\Symplify\ConfigTransformer\Naming\UniqueNaming;
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
    public function __construct(\ConfigTransformer20210604\Symplify\ConfigTransformer\Configuration\Configuration $configuration, \ConfigTransformer20210604\Symplify\ConfigTransformer\Naming\UniqueNaming $uniqueNaming, \ConfigTransformer20210604\Symplify\ConfigTransformer\Collector\XmlImportCollector $xmlImportCollector)
    {
        $this->configuration = $configuration;
        $this->uniqueNaming = $uniqueNaming;
        $this->xmlImportCollector = $xmlImportCollector;
    }
    public function createFromContainerBuilder(\ConfigTransformer20210604\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : \ConfigTransformer20210604\Symplify\ConfigTransformer\DependencyInjection\Loader\IdAwareXmlFileLoader
    {
        return new \ConfigTransformer20210604\Symplify\ConfigTransformer\DependencyInjection\Loader\IdAwareXmlFileLoader($containerBuilder, new \ConfigTransformer20210604\Symfony\Component\Config\FileLocator(), $this->configuration, $this->uniqueNaming, $this->xmlImportCollector);
    }
}
