<?php

declare (strict_types=1);
namespace ConfigTransformer2022022410\Symplify\Astral\PhpDocParser;

use ConfigTransformer2022022410\PhpParser\Comment\Doc;
use ConfigTransformer2022022410\PhpParser\Node;
use ConfigTransformer2022022410\PHPStan\PhpDocParser\Lexer\Lexer;
use ConfigTransformer2022022410\PHPStan\PhpDocParser\Parser\PhpDocParser;
use ConfigTransformer2022022410\PHPStan\PhpDocParser\Parser\TokenIterator;
use ConfigTransformer2022022410\Symplify\Astral\PhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode;
/**
 * @see \Symplify\Astral\Tests\PhpDocParser\SimplePhpDocParser\SimplePhpDocParserTest
 */
final class SimplePhpDocParser
{
    /**
     * @var \PHPStan\PhpDocParser\Parser\PhpDocParser
     */
    private $phpDocParser;
    /**
     * @var \PHPStan\PhpDocParser\Lexer\Lexer
     */
    private $lexer;
    public function __construct(\ConfigTransformer2022022410\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser, \ConfigTransformer2022022410\PHPStan\PhpDocParser\Lexer\Lexer $lexer)
    {
        $this->phpDocParser = $phpDocParser;
        $this->lexer = $lexer;
    }
    public function parseNode(\ConfigTransformer2022022410\PhpParser\Node $node) : ?\ConfigTransformer2022022410\Symplify\Astral\PhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode
    {
        $docComment = $node->getDocComment();
        if (!$docComment instanceof \ConfigTransformer2022022410\PhpParser\Comment\Doc) {
            return null;
        }
        return $this->parseDocBlock($docComment->getText());
    }
    public function parseDocBlock(string $docBlock) : \ConfigTransformer2022022410\Symplify\Astral\PhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode
    {
        $tokens = $this->lexer->tokenize($docBlock);
        $tokenIterator = new \ConfigTransformer2022022410\PHPStan\PhpDocParser\Parser\TokenIterator($tokens);
        $phpDocNode = $this->phpDocParser->parse($tokenIterator);
        return new \ConfigTransformer2022022410\Symplify\Astral\PhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode($phpDocNode->children);
    }
}
