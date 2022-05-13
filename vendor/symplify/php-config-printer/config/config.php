<?php

declare (strict_types=1);
namespace ConfigTransformer2022051310;

use ConfigTransformer2022051310\PhpParser\BuilderFactory;
use ConfigTransformer2022051310\PhpParser\NodeFinder;
use ConfigTransformer2022051310\PhpParser\NodeVisitor\ParentConnectingVisitor;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2022051310\Symfony\Component\Yaml\Parser;
use ConfigTransformer2022051310\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer2022051310\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer2022051310\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer2022051310\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory;
use ConfigTransformer2022051310\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer2022051310\Symplify\PackageBuilder\Php\TypeChecker;
use ConfigTransformer2022051310\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use function ConfigTransformer2022051310\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer2022051310\Symplify\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/ValueObject']);
    $services->set(\ConfigTransformer2022051310\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer2022051310\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer2022051310\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer2022051310\PhpParser\NodeVisitor\ParentConnectingVisitor::class);
    $services->set(\ConfigTransformer2022051310\Symplify\Astral\NodeFinder\SimpleNodeFinder::class);
    $services->set(\ConfigTransformer2022051310\Symplify\PackageBuilder\Php\TypeChecker::class);
    $services->set(\ConfigTransformer2022051310\Symplify\Astral\NodeValue\NodeValueResolver::class);
    $services->set(\ConfigTransformer2022051310\Symplify\Astral\Naming\SimpleNameResolver::class)->factory(\ConfigTransformer2022051310\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::class . '::create');
    $services->set(\ConfigTransformer2022051310\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer2022051310\Symfony\Component\DependencyInjection\Loader\Configurator\service('service_container')]);
    $services->set(\ConfigTransformer2022051310\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};
