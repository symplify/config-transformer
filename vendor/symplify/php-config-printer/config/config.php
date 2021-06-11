<?php

declare (strict_types=1);
namespace ConfigTransformer202106110;

use ConfigTransformer202106110\PhpParser\BuilderFactory;
use ConfigTransformer202106110\PhpParser\NodeFinder;
use ConfigTransformer202106110\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer202106110\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202106110\Symfony\Component\Yaml\Parser;
use ConfigTransformer202106110\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer202106110\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use function ConfigTransformer202106110\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\ConfigTransformer202106110\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202106110\Symplify\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/Dummy', __DIR__ . '/../src/Bundle']);
    $services->set(\ConfigTransformer202106110\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer202106110\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer202106110\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer202106110\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer202106110\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202106110\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
    $services->set(\ConfigTransformer202106110\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};