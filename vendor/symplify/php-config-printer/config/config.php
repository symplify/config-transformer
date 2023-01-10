<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202301;

use ConfigTransformerPrefix202301\PhpParser\BuilderFactory;
use ConfigTransformerPrefix202301\PhpParser\NodeFinder;
use ConfigTransformerPrefix202301\PhpParser\NodeVisitor\ParentConnectingVisitor;
use ConfigTransformerPrefix202301\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformerPrefix202301\Symfony\Component\Yaml\Parser;
use ConfigTransformerPrefix202301\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformerPrefix202301\Symplify\PackageBuilder\Php\TypeChecker;
use ConfigTransformerPrefix202301\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use function ConfigTransformerPrefix202301\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire();
    $services->load('Symplify\\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/ValueObject']);
    $services->set(NodeFinder::class);
    $services->set(Parser::class);
    $services->set(BuilderFactory::class);
    $services->set(ParentConnectingVisitor::class);
    $services->set(TypeChecker::class);
    $services->set(ParameterProvider::class)->args([service('service_container')]);
    $services->set(ClassLikeExistenceChecker::class);
};
