<?php

declare (strict_types=1);
namespace ConfigTransformer2021120210;

use ConfigTransformer2021120210\PhpParser\ConstExprEvaluator;
use ConfigTransformer2021120210\PhpParser\NodeFinder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2021120210\Symplify\Astral\PhpParser\SmartPhpParser;
use ConfigTransformer2021120210\Symplify\Astral\PhpParser\SmartPhpParserFactory;
use ConfigTransformer2021120210\Symplify\PackageBuilder\Php\TypeChecker;
use function ConfigTransformer2021120210\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->load('ConfigTransformer2021120210\Symplify\Astral\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/StaticFactory', __DIR__ . '/../src/ValueObject', __DIR__ . '/../src/NodeVisitor', __DIR__ . '/../src/PhpParser/SmartPhpParser.php']);
    $services->set(\ConfigTransformer2021120210\Symplify\Astral\PhpParser\SmartPhpParser::class)->factory([\ConfigTransformer2021120210\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer2021120210\Symplify\Astral\PhpParser\SmartPhpParserFactory::class), 'create']);
    $services->set(\ConfigTransformer2021120210\PhpParser\ConstExprEvaluator::class);
    $services->set(\ConfigTransformer2021120210\Symplify\PackageBuilder\Php\TypeChecker::class);
    $services->set(\ConfigTransformer2021120210\PhpParser\NodeFinder::class);
};
