<?php

declare (strict_types=1);
namespace ConfigTransformer2022053010\Symplify\Astral\PhpDocParser\StaticFactory;

use ConfigTransformer2022053010\PHPStan\PhpDocParser\Lexer\Lexer;
use ConfigTransformer2022053010\PHPStan\PhpDocParser\Parser\ConstExprParser;
use ConfigTransformer2022053010\PHPStan\PhpDocParser\Parser\PhpDocParser;
use ConfigTransformer2022053010\PHPStan\PhpDocParser\Parser\TypeParser;
use ConfigTransformer2022053010\Symplify\Astral\PhpDocParser\SimplePhpDocParser;
/**
 * @api
 */
final class SimplePhpDocParserStaticFactory
{
    public static function create() : \ConfigTransformer2022053010\Symplify\Astral\PhpDocParser\SimplePhpDocParser
    {
        $phpDocParser = new \ConfigTransformer2022053010\PHPStan\PhpDocParser\Parser\PhpDocParser(new \ConfigTransformer2022053010\PHPStan\PhpDocParser\Parser\TypeParser(), new \ConfigTransformer2022053010\PHPStan\PhpDocParser\Parser\ConstExprParser());
        return new \ConfigTransformer2022053010\Symplify\Astral\PhpDocParser\SimplePhpDocParser($phpDocParser, new \ConfigTransformer2022053010\PHPStan\PhpDocParser\Lexer\Lexer());
    }
}
