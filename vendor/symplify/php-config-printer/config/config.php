<?php

declare (strict_types=1);
namespace ConfigTransformer202106289;

use ConfigTransformer202106289\PhpParser\BuilderFactory;
use ConfigTransformer202106289\PhpParser\NodeFinder;
use ConfigTransformer202106289\PhpParser\NodeVisitor\ParentConnectingVisitor;
use ConfigTransformer202106289\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer202106289\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202106289\Symfony\Component\Yaml\Parser;
use ConfigTransformer202106289\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer202106289\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use function ConfigTransformer202106289\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\ConfigTransformer202106289\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202106289\Symplify\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/Dummy', __DIR__ . '/../src/Bundle', __DIR__ . '/../src/ValueObject/FullyQualifiedImport.php']);
    $services->set(\ConfigTransformer202106289\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer202106289\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer202106289\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer202106289\PhpParser\NodeVisitor\ParentConnectingVisitor::class);
    $services->set(\ConfigTransformer202106289\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer202106289\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202106289\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
    $services->set(\ConfigTransformer202106289\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};
