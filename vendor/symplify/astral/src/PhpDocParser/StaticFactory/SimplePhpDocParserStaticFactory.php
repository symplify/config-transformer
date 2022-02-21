<?php

declare (strict_types=1);
namespace ConfigTransformer202202215\Symplify\Astral\PhpDocParser\StaticFactory;

use ConfigTransformer202202215\PHPStan\PhpDocParser\Lexer\Lexer;
use ConfigTransformer202202215\PHPStan\PhpDocParser\Parser\ConstExprParser;
use ConfigTransformer202202215\PHPStan\PhpDocParser\Parser\PhpDocParser;
use ConfigTransformer202202215\PHPStan\PhpDocParser\Parser\TypeParser;
use ConfigTransformer202202215\Symplify\Astral\PhpDocParser\SimplePhpDocParser;
/**
 * @api
 */
final class SimplePhpDocParserStaticFactory
{
    public static function create() : \ConfigTransformer202202215\Symplify\Astral\PhpDocParser\SimplePhpDocParser
    {
        $phpDocParser = new \ConfigTransformer202202215\PHPStan\PhpDocParser\Parser\PhpDocParser(new \ConfigTransformer202202215\PHPStan\PhpDocParser\Parser\TypeParser(), new \ConfigTransformer202202215\PHPStan\PhpDocParser\Parser\ConstExprParser());
        return new \ConfigTransformer202202215\Symplify\Astral\PhpDocParser\SimplePhpDocParser($phpDocParser, new \ConfigTransformer202202215\PHPStan\PhpDocParser\Lexer\Lexer());
    }
}
