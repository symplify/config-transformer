<?php

declare (strict_types=1);
namespace ConfigTransformer202108239;

use ConfigTransformer202108239\PhpParser\BuilderFactory;
use ConfigTransformer202108239\PhpParser\NodeFinder;
use ConfigTransformer202108239\PhpParser\NodeVisitor\ParentConnectingVisitor;
use ConfigTransformer202108239\Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202108239\Symfony\Component\Yaml\Parser;
use ConfigTransformer202108239\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer202108239\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use function ConfigTransformer202108239\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202108239\Symplify\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/Dummy', __DIR__ . '/../src/Bundle', __DIR__ . '/../src/ValueObject/FullyQualifiedImport.php']);
    $services->set(\ConfigTransformer202108239\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer202108239\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer202108239\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer202108239\PhpParser\NodeVisitor\ParentConnectingVisitor::class);
    $services->set(\ConfigTransformer202108239\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer202108239\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202108239\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
    $services->set(\ConfigTransformer202108239\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};
