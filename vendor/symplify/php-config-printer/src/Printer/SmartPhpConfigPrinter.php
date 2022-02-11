<?php

declare (strict_types=1);
namespace ConfigTransformer202202112\Symplify\PhpConfigPrinter\Printer;

use ConfigTransformer202202112\Symplify\PhpConfigPrinter\NodeFactory\ContainerConfiguratorReturnClosureFactory;
use ConfigTransformer202202112\Symplify\PhpConfigPrinter\Printer\ArrayDecorator\ServiceConfigurationDecorator;
use ConfigTransformer202202112\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
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
    public function __construct(\ConfigTransformer202202112\Symplify\PhpConfigPrinter\NodeFactory\ContainerConfiguratorReturnClosureFactory $configuratorReturnClosureFactory, \ConfigTransformer202202112\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter $phpParserPhpConfigPrinter, \ConfigTransformer202202112\Symplify\PhpConfigPrinter\Printer\ArrayDecorator\ServiceConfigurationDecorator $serviceConfigurationDecorator)
    {
        $this->configuratorReturnClosureFactory = $configuratorReturnClosureFactory;
        $this->phpParserPhpConfigPrinter = $phpParserPhpConfigPrinter;
        $this->serviceConfigurationDecorator = $serviceConfigurationDecorator;
    }
    /**
     * @param array<string, mixed> $configuredServices
     */
    public function printConfiguredServices(array $configuredServices, bool $shouldUseConfigureMethod) : string
    {
        $servicesWithConfigureCalls = [];
        foreach ($configuredServices as $service => $configuration) {
            if ($configuration === null) {
                $servicesWithConfigureCalls[$service] = null;
            } else {
                $servicesWithConfigureCalls[$service] = $this->createServiceConfiguration($configuration, $service, $shouldUseConfigureMethod);
            }
        }
        $return = $this->configuratorReturnClosureFactory->createFromYamlArray([\ConfigTransformer202202112\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES => $servicesWithConfigureCalls]);
        return $this->phpParserPhpConfigPrinter->prettyPrintFile([$return]);
    }
    /**
     * @param mixed[] $configuration
     * @return array<string, mixed>
     */
    private function createServiceConfiguration(array $configuration, string $class, bool $shouldUseConfigureMethod) : array
    {
        if ($shouldUseConfigureMethod) {
            $configuration = $this->serviceConfigurationDecorator->decorate($configuration, $class, $shouldUseConfigureMethod);
            return ['configure' => $configuration];
        }
        $configuration = $this->serviceConfigurationDecorator->decorate($configuration, $class, \false);
        return ['calls' => [['configure', [$configuration]]]];
    }
}
