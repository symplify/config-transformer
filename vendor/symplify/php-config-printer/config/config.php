<?php

declare (strict_types=1);
namespace ConfigTransformer20220609;

use ConfigTransformer20220609\PhpParser\BuilderFactory;
use ConfigTransformer20220609\PhpParser\NodeFinder;
use ConfigTransformer20220609\PhpParser\NodeVisitor\ParentConnectingVisitor;
use ConfigTransformer20220609\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer20220609\Symfony\Component\Yaml\Parser;
use ConfigTransformer20220609\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer20220609\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer20220609\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory;
use ConfigTransformer20220609\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer20220609\Symplify\PackageBuilder\Php\TypeChecker;
use ConfigTransformer20220609\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use function ConfigTransformer20220609\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire();
    $services->load('Symplify\\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/ValueObject']);
    $services->set(NodeFinder::class);
    $services->set(Parser::class);
    $services->set(BuilderFactory::class);
    $services->set(ParentConnectingVisitor::class);
    $services->set(TypeChecker::class);
    $services->set(NodeValueResolver::class);
    $services->set(SimpleNameResolver::class)->factory(SimpleNameResolverStaticFactory::class . '::create');
    $services->set(ParameterProvider::class)->args([service('service_container')]);
    $services->set(ClassLikeExistenceChecker::class);
};
