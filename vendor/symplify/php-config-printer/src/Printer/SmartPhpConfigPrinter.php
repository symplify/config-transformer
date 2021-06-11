<?php

declare (strict_types=1);
namespace ConfigTransformer202106111\Symplify\PhpConfigPrinter\Printer;

use ConfigTransformer202106111\Symplify\PhpConfigPrinter\NodeFactory\ContainerConfiguratorReturnClosureFactory;
use ConfigTransformer202106111\Symplify\PhpConfigPrinter\Printer\ArrayDecorator\ServiceConfigurationDecorator;
use ConfigTransformer202106111\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * @see \Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\SmartPhpConfigPrinterTest
 */
final class SmartPhpConfigPrinter
{
    /**
     * @var ContainerConfiguratorReturnClosureFactory
     */
    private $configuratorReturnClosureFactory;
    /**
     * @var PhpParserPhpConfigPrinter
     */
    private $phpParserPhpConfigPrinter;
    /**
     * @var ServiceConfigurationDecorator
     */
    private $serviceConfigurationDecorator;
    public function __construct(\ConfigTransformer202106111\Symplify\PhpConfigPrinter\NodeFactory\ContainerConfiguratorReturnClosureFactory $configuratorReturnClosureFactory, \ConfigTransformer202106111\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter $phpParserPhpConfigPrinter, \ConfigTransformer202106111\Symplify\PhpConfigPrinter\Printer\ArrayDecorator\ServiceConfigurationDecorator $serviceConfigurationDecorator)
    {
        $this->configuratorReturnClosureFactory = $configuratorReturnClosureFactory;
        $this->phpParserPhpConfigPrinter = $phpParserPhpConfigPrinter;
        $this->serviceConfigurationDecorator = $serviceConfigurationDecorator;
    }
    /**
     * @param array<string, mixed[]|null> $configuredServices
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
        $return = $this->configuratorReturnClosureFactory->createFromYamlArray([\ConfigTransformer202106111\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES => $servicesWithConfigureCalls]);
        return $this->phpParserPhpConfigPrinter->prettyPrintFile([$return]);
    }
    /**
     * @param mixed[] $configuration
     * @return array<string, mixed>|null
     */
    private function createServiceConfiguration(array $configuration, string $class) : ?array
    {
        if ($configuration === []) {
            return null;
        }
        $configuration = $this->serviceConfigurationDecorator->decorate($configuration, $class);
        return ['calls' => [['configure', [$configuration]]]];
    }
}
