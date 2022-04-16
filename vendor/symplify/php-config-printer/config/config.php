<?php

declare (strict_types=1);
namespace ConfigTransformer202204166;

use ConfigTransformer202204166\PhpParser\BuilderFactory;
use ConfigTransformer202204166\PhpParser\NodeFinder;
use ConfigTransformer202204166\PhpParser\NodeVisitor\ParentConnectingVisitor;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202204166\Symfony\Component\Yaml\Parser;
use ConfigTransformer202204166\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer202204166\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202204166\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202204166\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory;
use ConfigTransformer202204166\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer202204166\Symplify\PackageBuilder\Php\TypeChecker;
use ConfigTransformer202204166\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use function ConfigTransformer202204166\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202204166\Symplify\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/ValueObject']);
    $services->set(\ConfigTransformer202204166\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer202204166\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer202204166\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer202204166\PhpParser\NodeVisitor\ParentConnectingVisitor::class);
    $services->set(\ConfigTransformer202204166\Symplify\Astral\NodeFinder\SimpleNodeFinder::class);
    $services->set(\ConfigTransformer202204166\Symplify\PackageBuilder\Php\TypeChecker::class);
    $services->set(\ConfigTransformer202204166\Symplify\Astral\NodeValue\NodeValueResolver::class);
    $services->set(\ConfigTransformer202204166\Symplify\Astral\Naming\SimpleNameResolver::class)->factory(\ConfigTransformer202204166\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::class . '::create');
    $services->set(\ConfigTransformer202204166\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer202204166\Symfony\Component\DependencyInjection\Loader\Configurator\service('service_container')]);
    $services->set(\ConfigTransformer202204166\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};
