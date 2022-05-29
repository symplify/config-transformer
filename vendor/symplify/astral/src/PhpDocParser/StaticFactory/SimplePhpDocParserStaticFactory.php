<?php

declare (strict_types=1);
namespace ConfigTransformer202205290\Symplify\Astral\PhpDocParser\StaticFactory;

use ConfigTransformer202205290\PHPStan\PhpDocParser\Lexer\Lexer;
use ConfigTransformer202205290\PHPStan\PhpDocParser\Parser\ConstExprParser;
use ConfigTransformer202205290\PHPStan\PhpDocParser\Parser\PhpDocParser;
use ConfigTransformer202205290\PHPStan\PhpDocParser\Parser\TypeParser;
use ConfigTransformer202205290\Symplify\Astral\PhpDocParser\SimplePhpDocParser;
/**
 * @api
 */
final class SimplePhpDocParserStaticFactory
{
    public static function create() : \ConfigTransformer202205290\Symplify\Astral\PhpDocParser\SimplePhpDocParser
    {
        $phpDocParser = new \ConfigTransformer202205290\PHPStan\PhpDocParser\Parser\PhpDocParser(new \ConfigTransformer202205290\PHPStan\PhpDocParser\Parser\TypeParser(), new \ConfigTransformer202205290\PHPStan\PhpDocParser\Parser\ConstExprParser());
        return new \ConfigTransformer202205290\Symplify\Astral\PhpDocParser\SimplePhpDocParser($phpDocParser, new \ConfigTransformer202205290\PHPStan\PhpDocParser\Lexer\Lexer());
    }
}
