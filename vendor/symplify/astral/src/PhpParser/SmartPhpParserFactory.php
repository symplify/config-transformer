<?php

declare (strict_types=1);
namespace ConfigTransformer202201155\Symplify\Astral\PhpParser;

use ConfigTransformer202201155\PhpParser\Lexer\Emulative;
use ConfigTransformer202201155\PhpParser\NodeVisitor\NameResolver;
use ConfigTransformer202201155\PhpParser\Parser;
use ConfigTransformer202201155\PhpParser\ParserFactory;
use ConfigTransformer202201155\PHPStan\Parser\CachedParser;
use ConfigTransformer202201155\PHPStan\Parser\SimpleParser;
/**
 * Based on PHPStan-based PHP-Parser best practices:
 *
 * @see https://github.com/rectorphp/rector/issues/6744#issuecomment-950282826
 * @see https://github.com/phpstan/phpstan-src/blob/99e4ae0dced58fe0be7a7aec3168a5e9d639240a/conf/config.neon#L1669-L1691
 */
final class SmartPhpParserFactory
{
    public function create() : \ConfigTransformer202201155\Symplify\Astral\PhpParser\SmartPhpParser
    {
        $nativePhpParser = $this->createNativePhpParser();
        $cachedParser = $this->createPHPStanParser($nativePhpParser);
        return new \ConfigTransformer202201155\Symplify\Astral\PhpParser\SmartPhpParser($cachedParser);
    }
    private function createNativePhpParser() : \ConfigTransformer202201155\PhpParser\Parser
    {
        $parserFactory = new \ConfigTransformer202201155\PhpParser\ParserFactory();
        $lexerEmulative = new \ConfigTransformer202201155\PhpParser\Lexer\Emulative();
        return $parserFactory->create(\ConfigTransformer202201155\PhpParser\ParserFactory::PREFER_PHP7, $lexerEmulative);
    }
    private function createPHPStanParser(\ConfigTransformer202201155\PhpParser\Parser $parser) : \ConfigTransformer202201155\PHPStan\Parser\CachedParser
    {
        $nameResolver = new \ConfigTransformer202201155\PhpParser\NodeVisitor\NameResolver();
        $simpleParser = new \ConfigTransformer202201155\PHPStan\Parser\SimpleParser($parser, $nameResolver);
        return new \ConfigTransformer202201155\PHPStan\Parser\CachedParser($simpleParser, 1024);
    }
}
