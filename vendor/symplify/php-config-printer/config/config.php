<?php

declare (strict_types=1);
namespace ConfigTransformer2021082310;

use ConfigTransformer2021082310\PhpParser\BuilderFactory;
use ConfigTransformer2021082310\PhpParser\NodeFinder;
use ConfigTransformer2021082310\PhpParser\NodeVisitor\ParentConnectingVisitor;
use ConfigTransformer2021082310\Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2021082310\Symfony\Component\Yaml\Parser;
use ConfigTransformer2021082310\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer2021082310\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use function ConfigTransformer2021082310\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer2021082310\Symplify\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/Dummy', __DIR__ . '/../src/Bundle', __DIR__ . '/../src/ValueObject/FullyQualifiedImport.php']);
    $services->set(\ConfigTransformer2021082310\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer2021082310\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer2021082310\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer2021082310\PhpParser\NodeVisitor\ParentConnectingVisitor::class);
    $services->set(\ConfigTransformer2021082310\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer2021082310\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer2021082310\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
    $services->set(\ConfigTransformer2021082310\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};
