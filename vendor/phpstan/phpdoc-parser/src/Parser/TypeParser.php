<?php

declare (strict_types=1);
namespace ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser;

use LogicException;
use ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast;
use ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer;
use function strpos;
use function trim;
class TypeParser
{
    /** @var ConstExprParser|null */
    private $constExprParser;
    public function __construct(?\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\ConstExprParser $constExprParser = null)
    {
        $this->constExprParser = $constExprParser;
    }
    /** @phpstan-impure */
    public function parse(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens) : \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        if ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_NULLABLE)) {
            $type = $this->parseNullable($tokens);
        } else {
            $type = $this->parseAtomic($tokens);
            if ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_UNION)) {
                $type = $this->parseUnion($tokens, $type);
            } elseif ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_INTERSECTION)) {
                $type = $this->parseIntersection($tokens, $type);
            }
        }
        return $type;
    }
    /** @phpstan-impure */
    private function subParse(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens) : \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        if ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_NULLABLE)) {
            $type = $this->parseNullable($tokens);
        } elseif ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_VARIABLE)) {
            $type = $this->parseConditionalForParameter($tokens, $tokens->currentTokenValue());
        } else {
            $type = $this->parseAtomic($tokens);
            if ($tokens->isCurrentTokenValue('is')) {
                $type = $this->parseConditional($tokens, $type);
            } else {
                $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
                if ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_UNION)) {
                    $type = $this->subParseUnion($tokens, $type);
                } elseif ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_INTERSECTION)) {
                    $type = $this->subParseIntersection($tokens, $type);
                }
            }
        }
        return $type;
    }
    /** @phpstan-impure */
    private function parseAtomic(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens) : \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        if ($tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_PARENTHESES)) {
            $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
            $type = $this->subParse($tokens);
            $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
            $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PARENTHESES);
            if ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_SQUARE_BRACKET)) {
                return $this->tryParseArrayOrOffsetAccess($tokens, $type);
            }
            return $type;
        }
        if ($tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_THIS_VARIABLE)) {
            $type = new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\ThisTypeNode();
            if ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_SQUARE_BRACKET)) {
                return $this->tryParseArrayOrOffsetAccess($tokens, $type);
            }
            return $type;
        }
        $currentTokenValue = $tokens->currentTokenValue();
        $tokens->pushSavePoint();
        // because of ConstFetchNode
        if ($tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER)) {
            $type = new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode($currentTokenValue);
            if (!$tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_DOUBLE_COLON)) {
                $tokens->dropSavePoint();
                // because of ConstFetchNode
                if ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_ANGLE_BRACKET)) {
                    $tokens->pushSavePoint();
                    $isHtml = $this->isHtml($tokens);
                    $tokens->rollback();
                    if ($isHtml) {
                        return $type;
                    }
                    $type = $this->parseGeneric($tokens, $type);
                    if ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_SQUARE_BRACKET)) {
                        $type = $this->tryParseArrayOrOffsetAccess($tokens, $type);
                    }
                } elseif ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_PARENTHESES)) {
                    $type = $this->tryParseCallable($tokens, $type);
                } elseif ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_SQUARE_BRACKET)) {
                    $type = $this->tryParseArrayOrOffsetAccess($tokens, $type);
                } elseif ($type->name === 'array' && $tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_CURLY_BRACKET) && !$tokens->isPrecededByHorizontalWhitespace()) {
                    $type = $this->parseArrayShape($tokens, $type);
                    if ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_SQUARE_BRACKET)) {
                        $type = $this->tryParseArrayOrOffsetAccess($tokens, $type);
                    }
                }
                return $type;
            } else {
                $tokens->rollback();
                // because of ConstFetchNode
            }
        } else {
            $tokens->dropSavePoint();
            // because of ConstFetchNode
        }
        $exception = new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\ParserException($tokens->currentTokenValue(), $tokens->currentTokenType(), $tokens->currentTokenOffset(), \ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER);
        if ($this->constExprParser === null) {
            throw $exception;
        }
        try {
            $constExpr = $this->constExprParser->parse($tokens, \true);
            if ($constExpr instanceof \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode) {
                throw $exception;
            }
            return new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\ConstTypeNode($constExpr);
        } catch (\LogicException $e) {
            throw $exception;
        }
    }
    /** @phpstan-impure */
    private function parseUnion(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens, \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode $type) : \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $types = [$type];
        while ($tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_UNION)) {
            $types[] = $this->parseAtomic($tokens);
        }
        return new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode($types);
    }
    /** @phpstan-impure */
    private function subParseUnion(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens, \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode $type) : \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $types = [$type];
        while ($tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_UNION)) {
            $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
            $types[] = $this->parseAtomic($tokens);
            $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        }
        return new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode($types);
    }
    /** @phpstan-impure */
    private function parseIntersection(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens, \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode $type) : \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $types = [$type];
        while ($tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_INTERSECTION)) {
            $types[] = $this->parseAtomic($tokens);
        }
        return new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode($types);
    }
    /** @phpstan-impure */
    private function subParseIntersection(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens, \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode $type) : \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $types = [$type];
        while ($tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_INTERSECTION)) {
            $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
            $types[] = $this->parseAtomic($tokens);
            $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        }
        return new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode($types);
    }
    /** @phpstan-impure */
    private function parseConditional(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens, \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode $subjectType) : \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER);
        $negated = \false;
        if ($tokens->isCurrentTokenValue('not')) {
            $negated = \true;
            $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER);
        }
        $targetType = $this->parse($tokens);
        $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_NULLABLE);
        $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        $ifType = $this->parse($tokens);
        $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_COLON);
        $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        $elseType = $this->parse($tokens);
        return new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\ConditionalTypeNode($subjectType, $targetType, $ifType, $elseType, $negated);
    }
    /** @phpstan-impure */
    private function parseConditionalForParameter(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens, string $parameterName) : \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_VARIABLE);
        $tokens->consumeTokenValue(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER, 'is');
        $negated = \false;
        if ($tokens->isCurrentTokenValue('not')) {
            $negated = \true;
            $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER);
        }
        $targetType = $this->parse($tokens);
        $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_NULLABLE);
        $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        $ifType = $this->parse($tokens);
        $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_COLON);
        $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        $elseType = $this->parse($tokens);
        return new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\ConditionalTypeForParameterNode($parameterName, $targetType, $ifType, $elseType, $negated);
    }
    /** @phpstan-impure */
    private function parseNullable(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens) : \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_NULLABLE);
        $type = new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode($tokens->currentTokenValue());
        $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER);
        if ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_ANGLE_BRACKET)) {
            $type = $this->parseGeneric($tokens, $type);
        } elseif ($type->name === 'array' && $tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_CURLY_BRACKET) && !$tokens->isPrecededByHorizontalWhitespace()) {
            $type = $this->parseArrayShape($tokens, $type);
        }
        if ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_SQUARE_BRACKET)) {
            $type = $this->tryParseArrayOrOffsetAccess($tokens, $type);
        }
        return new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode($type);
    }
    /** @phpstan-impure */
    public function isHtml(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens) : bool
    {
        $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_ANGLE_BRACKET);
        if (!$tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER)) {
            return \false;
        }
        $htmlTagName = $tokens->currentTokenValue();
        $tokens->next();
        if (!$tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_ANGLE_BRACKET)) {
            return \false;
        }
        while (!$tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_END)) {
            if ($tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_ANGLE_BRACKET) && \strpos($tokens->currentTokenValue(), '/' . $htmlTagName . '>') !== \false) {
                return \true;
            }
            $tokens->next();
        }
        return \false;
    }
    /** @phpstan-impure */
    public function parseGeneric(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens, \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode $baseType) : \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode
    {
        $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_ANGLE_BRACKET);
        $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        $genericTypes = [$this->parse($tokens)];
        $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        while ($tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_COMMA)) {
            $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
            if ($tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_ANGLE_BRACKET)) {
                // trailing comma case
                return new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode($baseType, $genericTypes);
            }
            $genericTypes[] = $this->parse($tokens);
            $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        }
        $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_ANGLE_BRACKET);
        return new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode($baseType, $genericTypes);
    }
    /** @phpstan-impure */
    private function parseCallable(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens, \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode $identifier) : \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_PARENTHESES);
        $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        $parameters = [];
        if (!$tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PARENTHESES)) {
            $parameters[] = $this->parseCallableParameter($tokens);
            $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
            while ($tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_COMMA)) {
                $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
                if ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PARENTHESES)) {
                    break;
                }
                $parameters[] = $this->parseCallableParameter($tokens);
                $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
            }
        }
        $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PARENTHESES);
        $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_COLON);
        $returnType = $this->parseCallableReturnType($tokens);
        return new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\CallableTypeNode($identifier, $parameters, $returnType);
    }
    /** @phpstan-impure */
    private function parseCallableParameter(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens) : \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\CallableTypeParameterNode
    {
        $type = $this->parse($tokens);
        $isReference = $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_REFERENCE);
        $isVariadic = $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_VARIADIC);
        if ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_VARIABLE)) {
            $parameterName = $tokens->currentTokenValue();
            $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_VARIABLE);
        } else {
            $parameterName = '';
        }
        $isOptional = $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_EQUAL);
        return new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\CallableTypeParameterNode($type, $isReference, $isVariadic, $parameterName, $isOptional);
    }
    /** @phpstan-impure */
    private function parseCallableReturnType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens) : \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        if ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_NULLABLE)) {
            $type = $this->parseNullable($tokens);
        } elseif ($tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_PARENTHESES)) {
            $type = $this->parse($tokens);
            $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PARENTHESES);
        } else {
            $type = new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode($tokens->currentTokenValue());
            $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER);
            if ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_ANGLE_BRACKET)) {
                $type = $this->parseGeneric($tokens, $type);
            } elseif ($type->name === 'array' && $tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_CURLY_BRACKET) && !$tokens->isPrecededByHorizontalWhitespace()) {
                $type = $this->parseArrayShape($tokens, $type);
            }
        }
        if ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_SQUARE_BRACKET)) {
            $type = $this->tryParseArrayOrOffsetAccess($tokens, $type);
        }
        return $type;
    }
    /** @phpstan-impure */
    private function tryParseCallable(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens, \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode $identifier) : \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        try {
            $tokens->pushSavePoint();
            $type = $this->parseCallable($tokens, $identifier);
            $tokens->dropSavePoint();
        } catch (\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\ParserException $e) {
            $tokens->rollback();
            $type = $identifier;
        }
        return $type;
    }
    /** @phpstan-impure */
    private function tryParseArrayOrOffsetAccess(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens, \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode $type) : \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        try {
            while ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_SQUARE_BRACKET)) {
                $tokens->pushSavePoint();
                $canBeOffsetAccessType = !$tokens->isPrecededByHorizontalWhitespace();
                $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_SQUARE_BRACKET);
                if ($canBeOffsetAccessType && !$tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_SQUARE_BRACKET)) {
                    $offset = $this->parse($tokens);
                    $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_SQUARE_BRACKET);
                    $tokens->dropSavePoint();
                    $type = new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\OffsetAccessTypeNode($type, $offset);
                } else {
                    $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_SQUARE_BRACKET);
                    $tokens->dropSavePoint();
                    $type = new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode($type);
                }
            }
        } catch (\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\ParserException $e) {
            $tokens->rollback();
        }
        return $type;
    }
    /** @phpstan-impure */
    private function parseArrayShape(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens, \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode $type) : \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode
    {
        $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_CURLY_BRACKET);
        if ($tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_CURLY_BRACKET)) {
            return new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode([]);
        }
        $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        $items = [$this->parseArrayShapeItem($tokens)];
        $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        while ($tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_COMMA)) {
            $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
            if ($tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_CURLY_BRACKET)) {
                // trailing comma case
                return new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode($items);
            }
            $items[] = $this->parseArrayShapeItem($tokens);
            $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        }
        $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
        $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_CURLY_BRACKET);
        return new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode($items);
    }
    /** @phpstan-impure */
    private function parseArrayShapeItem(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens) : \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode
    {
        try {
            $tokens->pushSavePoint();
            $key = $this->parseArrayShapeKey($tokens);
            $optional = $tokens->tryConsumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_NULLABLE);
            $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_COLON);
            $value = $this->parse($tokens);
            $tokens->dropSavePoint();
            return new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode($key, $optional, $value);
        } catch (\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\ParserException $e) {
            $tokens->rollback();
            $value = $this->parse($tokens);
            return new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode(null, \false, $value);
        }
    }
    /**
     * @phpstan-impure
     * @return Ast\ConstExpr\ConstExprIntegerNode|Ast\ConstExpr\ConstExprStringNode|Ast\Type\IdentifierTypeNode
     */
    private function parseArrayShapeKey(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Parser\TokenIterator $tokens)
    {
        if ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_INTEGER)) {
            $key = new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode($tokens->currentTokenValue());
            $tokens->next();
        } elseif ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_SINGLE_QUOTED_STRING)) {
            $key = new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode(\trim($tokens->currentTokenValue(), "'"));
            $tokens->next();
        } elseif ($tokens->isCurrentTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_DOUBLE_QUOTED_STRING)) {
            $key = new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode(\trim($tokens->currentTokenValue(), '"'));
            $tokens->next();
        } else {
            $key = new \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode($tokens->currentTokenValue());
            $tokens->consumeTokenType(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER);
        }
        return $key;
    }
}
