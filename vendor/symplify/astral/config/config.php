<?php

declare (strict_types=1);
namespace ConfigTransformer2021093010;

use ConfigTransformer2021093010\PhpParser\ConstExprEvaluator;
use ConfigTransformer2021093010\PhpParser\NodeFinder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2021093010\Symplify\PackageBuilder\Php\TypeChecker;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->load('ConfigTransformer2021093010\Symplify\Astral\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/StaticFactory', __DIR__ . '/../src/ValueObject', __DIR__ . '/../src/NodeVisitor']);
    $services->set(\ConfigTransformer2021093010\PhpParser\ConstExprEvaluator::class);
    $services->set(\ConfigTransformer2021093010\Symplify\PackageBuilder\Php\TypeChecker::class);
    $services->set(\ConfigTransformer2021093010\PhpParser\NodeFinder::class);
};
