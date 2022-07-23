<?php

declare (strict_types=1);
namespace ConfigTransformer202207;

use ConfigTransformer202207\PhpParser\BuilderFactory;
use ConfigTransformer202207\PhpParser\NodeFinder;
use ConfigTransformer202207\PhpParser\NodeVisitor\ParentConnectingVisitor;
use ConfigTransformer202207\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202207\Symfony\Component\Yaml\Parser;
use ConfigTransformer202207\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer202207\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202207\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory;
use ConfigTransformer202207\Symplify\Astral\TypeAwareNodeFinder;
use ConfigTransformer202207\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer202207\Symplify\PackageBuilder\Php\TypeChecker;
use ConfigTransformer202207\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use function ConfigTransformer202207\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire();
    $services->load('Symplify\\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/ValueObject']);
    $services->set(NodeFinder::class);
    $services->set(Parser::class);
    $services->set(BuilderFactory::class);
    $services->set(ParentConnectingVisitor::class);
    $services->set(TypeAwareNodeFinder::class);
    $services->set(TypeChecker::class);
    $services->set(NodeValueResolver::class);
    $services->set(SimpleNameResolver::class)->factory(SimpleNameResolverStaticFactory::class . '::create');
    $services->set(ParameterProvider::class)->args([service('service_container')]);
    $services->set(ClassLikeExistenceChecker::class);
};
