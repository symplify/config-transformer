<?php

declare (strict_types=1);
namespace ConfigTransformer202202218;

use ConfigTransformer202202218\PhpParser\ConstExprEvaluator;
use ConfigTransformer202202218\PhpParser\NodeFinder;
use ConfigTransformer202202218\PHPStan\PhpDocParser\Lexer\Lexer;
use ConfigTransformer202202218\PHPStan\PhpDocParser\Parser\ConstExprParser;
use ConfigTransformer202202218\PHPStan\PhpDocParser\Parser\PhpDocParser;
use ConfigTransformer202202218\PHPStan\PhpDocParser\Parser\TypeParser;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202202218\Symplify\Astral\PhpParser\SmartPhpParser;
use ConfigTransformer202202218\Symplify\Astral\PhpParser\SmartPhpParserFactory;
use ConfigTransformer202202218\Symplify\PackageBuilder\Php\TypeChecker;
use function ConfigTransformer202202218\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->load('ConfigTransformer202202218\Symplify\Astral\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/StaticFactory', __DIR__ . '/../src/ValueObject', __DIR__ . '/../src/NodeVisitor', __DIR__ . '/../src/PhpParser/SmartPhpParser.php', __DIR__ . '/../src/PhpDocParser/PhpDocNodeVisitor/CallablePhpDocNodeVisitor.php']);
    $services->set(\ConfigTransformer202202218\Symplify\Astral\PhpParser\SmartPhpParser::class)->factory([\ConfigTransformer202202218\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202202218\Symplify\Astral\PhpParser\SmartPhpParserFactory::class), 'create']);
    $services->set(\ConfigTransformer202202218\PhpParser\ConstExprEvaluator::class);
    $services->set(\ConfigTransformer202202218\Symplify\PackageBuilder\Php\TypeChecker::class);
    $services->set(\ConfigTransformer202202218\PhpParser\NodeFinder::class);
    // phpdoc parser
    $services->set(\ConfigTransformer202202218\PHPStan\PhpDocParser\Parser\PhpDocParser::class);
    $services->set(\ConfigTransformer202202218\PHPStan\PhpDocParser\Lexer\Lexer::class);
    $services->set(\ConfigTransformer202202218\PHPStan\PhpDocParser\Parser\TypeParser::class);
    $services->set(\ConfigTransformer202202218\PHPStan\PhpDocParser\Parser\ConstExprParser::class);
};
