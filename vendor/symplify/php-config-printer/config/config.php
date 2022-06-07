<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710;

use ConfigTransformer2022060710\PhpParser\BuilderFactory;
use ConfigTransformer2022060710\PhpParser\NodeFinder;
use ConfigTransformer2022060710\PhpParser\NodeVisitor\ParentConnectingVisitor;
use ConfigTransformer2022060710\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2022060710\Symfony\Component\Yaml\Parser;
use ConfigTransformer2022060710\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer2022060710\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer2022060710\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer2022060710\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory;
use ConfigTransformer2022060710\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer2022060710\Symplify\PackageBuilder\Php\TypeChecker;
use ConfigTransformer2022060710\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use function ConfigTransformer2022060710\Symfony\Component\DependencyInjection\Loader\Configurator\service;
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
