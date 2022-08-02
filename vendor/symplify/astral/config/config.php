<?php

declare (strict_types=1);
namespace ConfigTransformer202208;

use ConfigTransformer202208\PhpParser\ConstExprEvaluator;
use ConfigTransformer202208\PhpParser\NodeFinder;
use ConfigTransformer202208\PHPStan\PhpDocParser\Lexer\Lexer;
use ConfigTransformer202208\PHPStan\PhpDocParser\Parser\ConstExprParser;
use ConfigTransformer202208\PHPStan\PhpDocParser\Parser\PhpDocParser;
use ConfigTransformer202208\PHPStan\PhpDocParser\Parser\TypeParser;
use ConfigTransformer202208\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202208\Symplify\Astral\PhpParser\SmartPhpParser;
use ConfigTransformer202208\Symplify\Astral\PhpParser\SmartPhpParserFactory;
use ConfigTransformer202208\Symplify\PackageBuilder\Php\TypeChecker;
use function ConfigTransformer202208\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public();
    $services->load('Symplify\\Astral\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/StaticFactory', __DIR__ . '/../src/ValueObject', __DIR__ . '/../src/NodeVisitor', __DIR__ . '/../src/PhpParser/SmartPhpParser.php', __DIR__ . '/../src/PhpDocParser/PhpDocNodeVisitor/CallablePhpDocNodeVisitor.php']);
    $services->set(SmartPhpParser::class)->factory([service(SmartPhpParserFactory::class), 'create']);
    $services->set(ConstExprEvaluator::class);
    $services->set(TypeChecker::class);
    $services->set(NodeFinder::class);
    // phpdoc parser
    $services->set(PhpDocParser::class);
    $services->set(Lexer::class);
    $services->set(TypeParser::class);
    $services->set(ConstExprParser::class);
};
