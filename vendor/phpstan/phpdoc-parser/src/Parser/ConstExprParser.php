<?php

declare (strict_types=1);
namespace ConfigTransformer202203132\PHPStan\PhpDocParser\Parser;

use ConfigTransformer202203132\PHPStan\PhpDocParser\Ast;
use ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer;
class ConstExprParser
{
    public function parse(\ConfigTransformer202203132\PHPStan\PhpDocParser\Parser\TokenIterator $tokens, bool $trimStrings = \false) : \ConfigTransformer202203132\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
    {
        if ($tokens->isCurrentTokenType(\ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_FLOAT)) {
            $value = $tokens->currentTokenValue();
            $tokens->next();
            return new \ConfigTransformer202203132\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode($value);
        }
        if ($tokens->isCurrentTokenType(\ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_INTEGER)) {
            $value = $tokens->currentTokenValue();
            $tokens->next();
            return new \ConfigTransformer202203132\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode($value);
        }
        if ($tokens->isCurrentTokenType(\ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_SINGLE_QUOTED_STRING)) {
            $value = $tokens->currentTokenValue();
            if ($trimStrings) {
                $value = \trim($tokens->currentTokenValue(), "'");
            }
            $tokens->next();
            return new \ConfigTransformer202203132\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode($value);
        } elseif ($tokens->isCurrentTokenType(\ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_DOUBLE_QUOTED_STRING)) {
            $value = $tokens->currentTokenValue();
            if ($trimStrings) {
                $value = \trim($tokens->currentTokenValue(), '"');
            }
            $tokens->next();
            return new \ConfigTransformer202203132\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode($value);
        } elseif ($tokens->isCurrentTokenType(\ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER)) {
            $identifier = $tokens->currentTokenValue();
            $tokens->next();
            switch (\strtolower($identifier)) {
                case 'true':
                    return new \ConfigTransformer202203132\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode();
                case 'false':
                    return new \ConfigTransformer202203132\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode();
                case 'null':
                    return new \ConfigTransformer202203132\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode();
                case 'array':
                    $tokens->consumeTokenType(\ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_PARENTHESES);
                    return $this->parseArray($tokens, \ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PARENTHESES);
            }
            if ($tokens->tryConsumeTokenType(\ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_DOUBLE_COLON)) {
                $classConstantName = '';
                $lastType = null;
                while (\true) {
                    if ($lastType !== \ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER && $tokens->currentTokenType() === \ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER) {
                        $classConstantName .= $tokens->currentTokenValue();
                        $tokens->consumeTokenType(\ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER);
                        $lastType = \ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER;
                        continue;
                    }
                    if ($lastType !== \ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_WILDCARD && $tokens->tryConsumeTokenType(\ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_WILDCARD)) {
                        $classConstantName .= '*';
                        $lastType = \ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_WILDCARD;
                        if ($tokens->getSkippedHorizontalWhiteSpaceIfAny() !== '') {
                            break;
                        }
                        continue;
                    }
                    if ($lastType === null) {
                        // trigger parse error if nothing valid was consumed
                        $tokens->consumeTokenType(\ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_WILDCARD);
                    }
                    break;
                }
                return new \ConfigTransformer202203132\PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode($identifier, $classConstantName);
            }
            return new \ConfigTransformer202203132\PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode('', $identifier);
        } elseif ($tokens->tryConsumeTokenType(\ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_SQUARE_BRACKET)) {
            return $this->parseArray($tokens, \ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_SQUARE_BRACKET);
        }
        throw new \LogicException($tokens->currentTokenValue());
    }
    private function parseArray(\ConfigTransformer202203132\PHPStan\PhpDocParser\Parser\TokenIterator $tokens, int $endToken) : \ConfigTransformer202203132\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode
    {
        $items = [];
        if (!$tokens->tryConsumeTokenType($endToken)) {
            do {
                $items[] = $this->parseArrayItem($tokens);
            } while ($tokens->tryConsumeTokenType(\ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_COMMA) && !$tokens->isCurrentTokenType($endToken));
            $tokens->consumeTokenType($endToken);
        }
        return new \ConfigTransformer202203132\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode($items);
    }
    private function parseArrayItem(\ConfigTransformer202203132\PHPStan\PhpDocParser\Parser\TokenIterator $tokens) : \ConfigTransformer202203132\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode
    {
        $expr = $this->parse($tokens);
        if ($tokens->tryConsumeTokenType(\ConfigTransformer202203132\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_DOUBLE_ARROW)) {
            $key = $expr;
            $value = $this->parse($tokens);
        } else {
            $key = null;
            $value = $expr;
        }
        return new \ConfigTransformer202203132\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayItemNode($key, $value);
    }
}
