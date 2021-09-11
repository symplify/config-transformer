<?php

declare (strict_types=1);
namespace ConfigTransformer202109116;

use ConfigTransformer202109116\PhpParser\BuilderFactory;
use ConfigTransformer202109116\PhpParser\NodeFinder;
use ConfigTransformer202109116\PhpParser\NodeVisitor\ParentConnectingVisitor;
use ConfigTransformer202109116\Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202109116\Symfony\Component\Yaml\Parser;
use ConfigTransformer202109116\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer202109116\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use function ConfigTransformer202109116\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202109116\Symplify\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/Dummy', __DIR__ . '/../src/Bundle', __DIR__ . '/../src/ValueObject/FullyQualifiedImport.php']);
    $services->set(\ConfigTransformer202109116\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer202109116\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer202109116\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer202109116\PhpParser\NodeVisitor\ParentConnectingVisitor::class);
    $services->set(\ConfigTransformer202109116\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer202109116\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202109116\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
    $services->set(\ConfigTransformer202109116\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};
