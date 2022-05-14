<?php

declare (strict_types=1);
namespace ConfigTransformer202205141;

use ConfigTransformer202205141\PhpParser\BuilderFactory;
use ConfigTransformer202205141\PhpParser\NodeFinder;
use ConfigTransformer202205141\PhpParser\NodeVisitor\ParentConnectingVisitor;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202205141\Symfony\Component\Yaml\Parser;
use ConfigTransformer202205141\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer202205141\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202205141\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202205141\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory;
use ConfigTransformer202205141\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer202205141\Symplify\PackageBuilder\Php\TypeChecker;
use ConfigTransformer202205141\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use function ConfigTransformer202205141\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202205141\Symplify\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/ValueObject']);
    $services->set(\ConfigTransformer202205141\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer202205141\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer202205141\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer202205141\PhpParser\NodeVisitor\ParentConnectingVisitor::class);
    $services->set(\ConfigTransformer202205141\Symplify\Astral\NodeFinder\SimpleNodeFinder::class);
    $services->set(\ConfigTransformer202205141\Symplify\PackageBuilder\Php\TypeChecker::class);
    $services->set(\ConfigTransformer202205141\Symplify\Astral\NodeValue\NodeValueResolver::class);
    $services->set(\ConfigTransformer202205141\Symplify\Astral\Naming\SimpleNameResolver::class)->factory(\ConfigTransformer202205141\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::class . '::create');
    $services->set(\ConfigTransformer202205141\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer202205141\Symfony\Component\DependencyInjection\Loader\Configurator\service('service_container')]);
    $services->set(\ConfigTransformer202205141\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};
