<?php

declare (strict_types=1);
namespace ConfigTransformer202208\Symplify\Astral\PhpDocParser\StaticFactory;

use ConfigTransformer202208\PHPStan\PhpDocParser\Lexer\Lexer;
use ConfigTransformer202208\PHPStan\PhpDocParser\Parser\ConstExprParser;
use ConfigTransformer202208\PHPStan\PhpDocParser\Parser\PhpDocParser;
use ConfigTransformer202208\PHPStan\PhpDocParser\Parser\TypeParser;
use ConfigTransformer202208\Symplify\Astral\PhpDocParser\SimplePhpDocParser;
/**
 * @api
 */
final class SimplePhpDocParserStaticFactory
{
    public static function create() : SimplePhpDocParser
    {
        $phpDocParser = new PhpDocParser(new TypeParser(), new ConstExprParser());
        return new SimplePhpDocParser($phpDocParser, new Lexer());
    }
}
