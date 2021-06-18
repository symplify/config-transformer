<?php

declare (strict_types=1);
namespace ConfigTransformer2021061810;

use ConfigTransformer2021061810\PhpParser\BuilderFactory;
use ConfigTransformer2021061810\PhpParser\NodeFinder;
use ConfigTransformer2021061810\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer2021061810\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2021061810\Symfony\Component\Yaml\Parser;
use ConfigTransformer2021061810\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer2021061810\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use function ConfigTransformer2021061810\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\ConfigTransformer2021061810\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer2021061810\Symplify\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/Dummy', __DIR__ . '/../src/Bundle']);
    $services->set(\ConfigTransformer2021061810\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer2021061810\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer2021061810\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer2021061810\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer2021061810\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer2021061810\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
    $services->set(\ConfigTransformer2021061810\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};
