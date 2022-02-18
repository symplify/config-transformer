<?php

declare (strict_types=1);
namespace ConfigTransformer202202183\Symplify\Astral\PhpParser;

use ConfigTransformer202202183\PhpParser\Lexer\Emulative;
use ConfigTransformer202202183\PhpParser\NodeVisitor\NameResolver;
use ConfigTransformer202202183\PhpParser\Parser;
use ConfigTransformer202202183\PhpParser\ParserFactory;
use ConfigTransformer202202183\PHPStan\Parser\CachedParser;
use ConfigTransformer202202183\PHPStan\Parser\SimpleParser;
/**
 * Based on PHPStan-based PHP-Parser best practices:
 *
 * @see https://github.com/rectorphp/rector/issues/6744#issuecomment-950282826
 * @see https://github.com/phpstan/phpstan-src/blob/99e4ae0dced58fe0be7a7aec3168a5e9d639240a/conf/config.neon#L1669-L1691
 */
final class SmartPhpParserFactory
{
    public function create() : \ConfigTransformer202202183\Symplify\Astral\PhpParser\SmartPhpParser
    {
        $nativePhpParser = $this->createNativePhpParser();
        $cachedParser = $this->createPHPStanParser($nativePhpParser);
        return new \ConfigTransformer202202183\Symplify\Astral\PhpParser\SmartPhpParser($cachedParser);
    }
    private function createNativePhpParser() : \ConfigTransformer202202183\PhpParser\Parser
    {
        $parserFactory = new \ConfigTransformer202202183\PhpParser\ParserFactory();
        $lexerEmulative = new \ConfigTransformer202202183\PhpParser\Lexer\Emulative();
        return $parserFactory->create(\ConfigTransformer202202183\PhpParser\ParserFactory::PREFER_PHP7, $lexerEmulative);
    }
    private function createPHPStanParser(\ConfigTransformer202202183\PhpParser\Parser $parser) : \ConfigTransformer202202183\PHPStan\Parser\CachedParser
    {
        $nameResolver = new \ConfigTransformer202202183\PhpParser\NodeVisitor\NameResolver();
        $simpleParser = new \ConfigTransformer202202183\PHPStan\Parser\SimpleParser($parser, $nameResolver);
        return new \ConfigTransformer202202183\PHPStan\Parser\CachedParser($simpleParser, 1024);
    }
}
