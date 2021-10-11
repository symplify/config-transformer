<?php

declare (strict_types=1);
namespace ConfigTransformer202110111;

use ConfigTransformer202110111\PhpParser\BuilderFactory;
use ConfigTransformer202110111\PhpParser\NodeFinder;
use ConfigTransformer202110111\PhpParser\NodeVisitor\ParentConnectingVisitor;
use ConfigTransformer202110111\Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202110111\Symfony\Component\Yaml\Parser;
use ConfigTransformer202110111\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer202110111\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202110111\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202110111\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory;
use ConfigTransformer202110111\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer202110111\Symplify\PackageBuilder\Php\TypeChecker;
use ConfigTransformer202110111\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use function ConfigTransformer202110111\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202110111\Symplify\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/Dummy', __DIR__ . '/../src/Bundle', __DIR__ . '/../src/ValueObject/FullyQualifiedImport.php']);
    $services->set(\ConfigTransformer202110111\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer202110111\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer202110111\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer202110111\PhpParser\NodeVisitor\ParentConnectingVisitor::class);
    $services->set(\ConfigTransformer202110111\Symplify\Astral\NodeFinder\SimpleNodeFinder::class);
    $services->set(\ConfigTransformer202110111\Symplify\PackageBuilder\Php\TypeChecker::class);
    $services->set(\ConfigTransformer202110111\Symplify\Astral\NodeValue\NodeValueResolver::class);
    $services->set(\ConfigTransformer202110111\Symplify\Astral\Naming\SimpleNameResolver::class)->factory(\ConfigTransformer202110111\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::class . '::create');
    $services->set(\ConfigTransformer202110111\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer202110111\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202110111\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
    $services->set(\ConfigTransformer202110111\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};
