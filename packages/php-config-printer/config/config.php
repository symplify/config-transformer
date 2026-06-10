<?php

declare(strict_types=1);

use PhpParser\BuilderFactory;
use PhpParser\NodeFinder;
use PhpParser\NodeVisitor\ParentConnectingVisitor;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Yaml\Parser;
use Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use Symplify\PhpConfigPrinter\Contract\NodeVisitor\PrePrintNodeVisitorInterface;
use Symplify\PhpConfigPrinter\Contract\RoutingCaseConverterInterface;
use Symplify\PhpConfigPrinter\NodeFactory\ContainerConfiguratorReturnClosureFactory;
use Symplify\PhpConfigPrinter\NodeFactory\RoutingConfiguratorReturnClosureFactory;
use Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->public()
        ->autowire();

    $services->load('Symplify\PhpConfigPrinter\\', __DIR__ . '/../src')
        ->exclude([__DIR__ . '/../src/ValueObject']);

    $services->load(
        'Symplify\\PhpConfigPrinter\\CaseConverter\\',
        __DIR__ . '/../src/CaseConverter'
    )
        ->exclude(__DIR__ . '/../src/CaseConverter/NestedCaseConverter/InstanceOfNestedCaseConverter.php')
        ->tag(CaseConverterInterface::class);

    $services->load(
        'Symplify\\PhpConfigPrinter\\RoutingCaseConverter\\',
        __DIR__ . '/../src/RoutingCaseConverter'
    )->tag(RoutingCaseConverterInterface::class);

    $services->load(
        'Symplify\\PhpConfigPrinter\\ServiceOptionConverter\\',
        __DIR__ . '/../src/ServiceOptionConverter'
    )->tag(ServiceOptionsKeyYamlToPhpFactoryInterface::class);

    $services->set(ContainerConfiguratorReturnClosureFactory::class)
        ->arg('$caseConverters', tagged_iterator(CaseConverterInterface::class));

    $services->set(RoutingConfiguratorReturnClosureFactory::class)
        ->arg('$routingCaseConverters', tagged_iterator(RoutingCaseConverterInterface::class));

    $services->set(ServiceOptionNodeFactory::class)
        ->arg('$serviceOptionKeyYamlToPhpFactories', tagged_iterator(ServiceOptionsKeyYamlToPhpFactoryInterface::class));

    $services->set(PhpParserPhpConfigPrinter::class)
        ->arg('$prePrintNodeVisitors', tagged_iterator(PrePrintNodeVisitorInterface::class));

    $services->set(NodeFinder::class);
    $services->set(Parser::class);
    $services->set(BuilderFactory::class);
    $services->set(ParentConnectingVisitor::class);
};
