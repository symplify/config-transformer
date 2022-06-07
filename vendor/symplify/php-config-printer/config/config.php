<?php

declare (strict_types=1);
namespace ConfigTransformer202206072;

use ConfigTransformer202206072\PhpParser\BuilderFactory;
use ConfigTransformer202206072\PhpParser\NodeFinder;
use ConfigTransformer202206072\PhpParser\NodeVisitor\ParentConnectingVisitor;
use ConfigTransformer202206072\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202206072\Symfony\Component\Yaml\Parser;
use ConfigTransformer202206072\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer202206072\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202206072\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202206072\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory;
use ConfigTransformer202206072\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer202206072\Symplify\PackageBuilder\Php\TypeChecker;
use ConfigTransformer202206072\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use function ConfigTransformer202206072\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire();
    $services->load('Symplify\\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/ValueObject']);
    $services->set(NodeFinder::class);
    $services->set(Parser::class);
    $services->set(BuilderFactory::class);
    $services->set(ParentConnectingVisitor::class);
    $services->set(SimpleNodeFinder::class);
    $services->set(TypeChecker::class);
    $services->set(NodeValueResolver::class);
    $services->set(SimpleNameResolver::class)->factory(SimpleNameResolverStaticFactory::class . '::create');
    $services->set(ParameterProvider::class)->args([service('service_container')]);
    $services->set(ClassLikeExistenceChecker::class);
};
