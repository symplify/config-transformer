<?php

declare (strict_types=1);
namespace ConfigTransformer202211;

use ConfigTransformer202211\PhpParser\BuilderFactory;
use ConfigTransformer202211\PhpParser\NodeFinder;
use ConfigTransformer202211\PhpParser\NodeVisitor\ParentConnectingVisitor;
use ConfigTransformer202211\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202211\Symfony\Component\Yaml\Parser;
use ConfigTransformer202211\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer202211\Symplify\PackageBuilder\Php\TypeChecker;
use ConfigTransformer202211\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use function ConfigTransformer202211\Symfony\Component\DependencyInjection\Loader\Configurator\service;
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
