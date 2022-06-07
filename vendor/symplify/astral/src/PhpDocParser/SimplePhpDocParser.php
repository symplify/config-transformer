<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\Symplify\Astral\PhpDocParser;

use ConfigTransformer2022060710\PhpParser\Comment\Doc;
use ConfigTransformer2022060710\PhpParser\Node;
use ConfigTransformer2022060710\PHPStan\PhpDocParser\Lexer\Lexer;
use ConfigTransformer2022060710\PHPStan\PhpDocParser\Parser\PhpDocParser;
use ConfigTransformer2022060710\PHPStan\PhpDocParser\Parser\TokenIterator;
use ConfigTransformer2022060710\Symplify\Astral\PhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode;
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
    public function __construct(PhpDocParser $phpDocParser, Lexer $lexer)
    {
        $this->phpDocParser = $phpDocParser;
        $this->lexer = $lexer;
    }
    public function parseNode(Node $node) : ?SimplePhpDocNode
    {
        $docComment = $node->getDocComment();
        if (!$docComment instanceof Doc) {
            return null;
        }
        return $this->parseDocBlock($docComment->getText());
    }
    public function parseDocBlock(string $docBlock) : SimplePhpDocNode
    {
        $tokens = $this->lexer->tokenize($docBlock);
        $tokenIterator = new TokenIterator($tokens);
        $phpDocNode = $this->phpDocParser->parse($tokenIterator);
        return new SimplePhpDocNode($phpDocNode->children);
    }
}
