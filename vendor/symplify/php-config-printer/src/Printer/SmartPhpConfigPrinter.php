<?php

declare (strict_types=1);
namespace ConfigTransformer2022053010\Symplify\PhpConfigPrinter\Printer;

use ConfigTransformer2022053010\Symplify\PhpConfigPrinter\NodeFactory\ContainerConfiguratorReturnClosureFactory;
use ConfigTransformer2022053010\Symplify\PhpConfigPrinter\Printer\ArrayDecorator\ServiceConfigurationDecorator;
use ConfigTransformer2022053010\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * @api
 * @see \Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\SmartPhpConfigPrinterTest
 */
final class SmartPhpConfigPrinter
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ContainerConfiguratorReturnClosureFactory
     */
    private $configuratorReturnClosureFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter
     */
    private $phpParserPhpConfigPrinter;
    /**
     * @var \Symplify\PhpConfigPrinter\Printer\ArrayDecorator\ServiceConfigurationDecorator
     */
    private $serviceConfigurationDecorator;
    public function __construct(\ConfigTransformer2022053010\Symplify\PhpConfigPrinter\NodeFactory\ContainerConfiguratorReturnClosureFactory $configuratorReturnClosureFactory, \ConfigTransformer2022053010\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter $phpParserPhpConfigPrinter, \ConfigTransformer2022053010\Symplify\PhpConfigPrinter\Printer\ArrayDecorator\ServiceConfigurationDecorator $serviceConfigurationDecorator)
    {
        $this->configuratorReturnClosureFactory = $configuratorReturnClosureFactory;
        $this->phpParserPhpConfigPrinter = $phpParserPhpConfigPrinter;
        $this->serviceConfigurationDecorator = $serviceConfigurationDecorator;
    }
    /**
     * @param array<string, mixed> $configuredServices
     */
    public function printConfiguredServices(array $configuredServices) : string
    {
        $servicesWithConfigureCalls = [];
        foreach ($configuredServices as $service => $configuration) {
            if ($configuration === null) {
                $servicesWithConfigureCalls[$service] = null;
            } else {
                $servicesWithConfigureCalls[$service] = $this->createServiceConfiguration($configuration, $service);
            }
        }
        $return = $this->configuratorReturnClosureFactory->createFromYamlArray([\ConfigTransformer2022053010\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES => $servicesWithConfigureCalls]);
        return $this->phpParserPhpConfigPrinter->prettyPrintFile([$return]);
    }
    /**
     * @param mixed[] $configuration
     * @return array{calls: mixed[]}
     */
    private function createServiceConfiguration(array $configuration, string $class) : array
    {
        $configuration = $this->serviceConfigurationDecorator->decorate($configuration, $class);
        return ['calls' => [['configure', [$configuration]]]];
    }
}
