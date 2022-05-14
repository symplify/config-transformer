<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202205147\Symfony\Component\ExpressionLanguage;

/**
 * Parsers a token stream.
 *
 * This parser implements a "Precedence climbing" algorithm.
 *
 * @see http://www.engr.mun.ca/~theo/Misc/exp_parsing.htm
 * @see http://en.wikipedia.org/wiki/Operator-precedence_parser
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Parser
{
    public const OPERATOR_LEFT = 1;
    public const OPERATOR_RIGHT = 2;
    private $stream;
    /**
     * @var mixed[]
     */
    private $unaryOperators;
    /**
     * @var mixed[]
     */
    private $binaryOperators;
    /**
     * @var mixed[]
     */
    private $functions;
    /**
     * @var mixed[]|null
     */
    private $names;
    /**
     * @var bool
     */
    private $lint = \false;
    public function __construct(array $functions)
    {
        $this->functions = $functions;
        $this->unaryOperators = ['not' => ['precedence' => 50], '!' => ['precedence' => 50], '-' => ['precedence' => 500], '+' => ['precedence' => 500]];
        $this->binaryOperators = ['or' => ['precedence' => 10, 'associativity' => self::OPERATOR_LEFT], '||' => ['precedence' => 10, 'associativity' => self::OPERATOR_LEFT], 'and' => ['precedence' => 15, 'associativity' => self::OPERATOR_LEFT], '&&' => ['precedence' => 15, 'associativity' => self::OPERATOR_LEFT], '|' => ['precedence' => 16, 'associativity' => self::OPERATOR_LEFT], '^' => ['precedence' => 17, 'associativity' => self::OPERATOR_LEFT], '&' => ['precedence' => 18, 'associativity' => self::OPERATOR_LEFT], '==' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], '===' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], '!=' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], '!==' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], '<' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], '>' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], '>=' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], '<=' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], 'not in' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], 'in' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], 'matches' => ['precedence' => 20, 'associativity' => self::OPERATOR_LEFT], '..' => ['precedence' => 25, 'associativity' => self::OPERATOR_LEFT], '+' => ['precedence' => 30, 'associativity' => self::OPERATOR_LEFT], '-' => ['precedence' => 30, 'associativity' => self::OPERATOR_LEFT], '~' => ['precedence' => 40, 'associativity' => self::OPERATOR_LEFT], '*' => ['precedence' => 60, 'associativity' => self::OPERATOR_LEFT], '/' => ['precedence' => 60, 'associativity' => self::OPERATOR_LEFT], '%' => ['precedence' => 60, 'associativity' => self::OPERATOR_LEFT], '**' => ['precedence' => 200, 'associativity' => self::OPERATOR_RIGHT]];
    }
    /**
     * Converts a token stream to a node tree.
     *
     * The valid names is an array where the values
     * are the names that the user can use in an expression.
     *
     * If the variable name in the compiled PHP code must be
     * different, define it as the key.
     *
     * For instance, ['this' => 'container'] means that the
     * variable 'container' can be used in the expression
     * but the compiled code will use 'this'.
     *
     * @throws SyntaxError
     */
    public function parse(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\TokenStream $stream, array $names = []) : \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\Node
    {
        $this->lint = \false;
        return $this->doParse($stream, $names);
    }
    /**
     * Validates the syntax of an expression.
     *
     * The syntax of the passed expression will be checked, but not parsed.
     * If you want to skip checking dynamic variable names, pass `null` instead of the array.
     *
     * @throws SyntaxError When the passed expression is invalid
     */
    public function lint(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\TokenStream $stream, ?array $names = []) : void
    {
        $this->lint = \true;
        $this->doParse($stream, $names);
    }
    /**
     * @throws SyntaxError
     */
    private function doParse(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\TokenStream $stream, ?array $names = []) : \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\Node
    {
        $this->stream = $stream;
        $this->names = $names;
        $node = $this->parseExpression();
        if (!$stream->isEOF()) {
            throw new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\SyntaxError(\sprintf('Unexpected token "%s" of value "%s".', $stream->current->type, $stream->current->value), $stream->current->cursor, $stream->getExpression());
        }
        unset($this->stream, $this->names);
        return $node;
    }
    public function parseExpression(int $precedence = 0)
    {
        $expr = $this->getPrimary();
        $token = $this->stream->current;
        while ($token->test(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::OPERATOR_TYPE) && isset($this->binaryOperators[$token->value]) && $this->binaryOperators[$token->value]['precedence'] >= $precedence) {
            $op = $this->binaryOperators[$token->value];
            $this->stream->next();
            $expr1 = $this->parseExpression(self::OPERATOR_LEFT === $op['associativity'] ? $op['precedence'] + 1 : $op['precedence']);
            $expr = new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\BinaryNode($token->value, $expr, $expr1);
            $token = $this->stream->current;
        }
        if (0 === $precedence) {
            return $this->parseConditionalExpression($expr);
        }
        return $expr;
    }
    protected function getPrimary()
    {
        $token = $this->stream->current;
        if ($token->test(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::OPERATOR_TYPE) && isset($this->unaryOperators[$token->value])) {
            $operator = $this->unaryOperators[$token->value];
            $this->stream->next();
            $expr = $this->parseExpression($operator['precedence']);
            return $this->parsePostfixExpression(new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\UnaryNode($token->value, $expr));
        }
        if ($token->test(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, '(')) {
            $this->stream->next();
            $expr = $this->parseExpression();
            $this->stream->expect(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, ')', 'An opened parenthesis is not properly closed');
            return $this->parsePostfixExpression($expr);
        }
        return $this->parsePrimaryExpression();
    }
    protected function parseConditionalExpression(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\Node $expr)
    {
        while ($this->stream->current->test(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, '?')) {
            $this->stream->next();
            if (!$this->stream->current->test(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, ':')) {
                $expr2 = $this->parseExpression();
                if ($this->stream->current->test(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, ':')) {
                    $this->stream->next();
                    $expr3 = $this->parseExpression();
                } else {
                    $expr3 = new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\ConstantNode(null);
                }
            } else {
                $this->stream->next();
                $expr2 = $expr;
                $expr3 = $this->parseExpression();
            }
            $expr = new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\ConditionalNode($expr, $expr2, $expr3);
        }
        return $expr;
    }
    public function parsePrimaryExpression()
    {
        $token = $this->stream->current;
        switch ($token->type) {
            case \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::NAME_TYPE:
                $this->stream->next();
                switch ($token->value) {
                    case 'true':
                    case 'TRUE':
                        return new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\ConstantNode(\true);
                    case 'false':
                    case 'FALSE':
                        return new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\ConstantNode(\false);
                    case 'null':
                    case 'NULL':
                        return new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\ConstantNode(null);
                    default:
                        if ('(' === $this->stream->current->value) {
                            if (\false === isset($this->functions[$token->value])) {
                                throw new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\SyntaxError(\sprintf('The function "%s" does not exist.', $token->value), $token->cursor, $this->stream->getExpression(), $token->value, \array_keys($this->functions));
                            }
                            $node = new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\FunctionNode($token->value, $this->parseArguments());
                        } else {
                            if (!$this->lint || \is_array($this->names)) {
                                if (!\in_array($token->value, $this->names, \true)) {
                                    throw new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\SyntaxError(\sprintf('Variable "%s" is not valid.', $token->value), $token->cursor, $this->stream->getExpression(), $token->value, $this->names);
                                }
                                // is the name used in the compiled code different
                                // from the name used in the expression?
                                if (\is_int($name = \array_search($token->value, $this->names))) {
                                    $name = $token->value;
                                }
                            } else {
                                $name = $token->value;
                            }
                            $node = new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\NameNode($name);
                        }
                }
                break;
            case \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::NUMBER_TYPE:
            case \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::STRING_TYPE:
                $this->stream->next();
                return new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\ConstantNode($token->value);
            default:
                if ($token->test(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, '[')) {
                    $node = $this->parseArrayExpression();
                } elseif ($token->test(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, '{')) {
                    $node = $this->parseHashExpression();
                } else {
                    throw new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\SyntaxError(\sprintf('Unexpected token "%s" of value "%s".', $token->type, $token->value), $token->cursor, $this->stream->getExpression());
                }
        }
        return $this->parsePostfixExpression($node);
    }
    public function parseArrayExpression()
    {
        $this->stream->expect(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, '[', 'An array element was expected');
        $node = new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\ArrayNode();
        $first = \true;
        while (!$this->stream->current->test(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, ']')) {
            if (!$first) {
                $this->stream->expect(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, ',', 'An array element must be followed by a comma');
                // trailing ,?
                if ($this->stream->current->test(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, ']')) {
                    break;
                }
            }
            $first = \false;
            $node->addElement($this->parseExpression());
        }
        $this->stream->expect(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, ']', 'An opened array is not properly closed');
        return $node;
    }
    public function parseHashExpression()
    {
        $this->stream->expect(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, '{', 'A hash element was expected');
        $node = new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\ArrayNode();
        $first = \true;
        while (!$this->stream->current->test(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, '}')) {
            if (!$first) {
                $this->stream->expect(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, ',', 'A hash value must be followed by a comma');
                // trailing ,?
                if ($this->stream->current->test(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, '}')) {
                    break;
                }
            }
            $first = \false;
            // a hash key can be:
            //
            //  * a number -- 12
            //  * a string -- 'a'
            //  * a name, which is equivalent to a string -- a
            //  * an expression, which must be enclosed in parentheses -- (1 + 2)
            if ($this->stream->current->test(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::STRING_TYPE) || $this->stream->current->test(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::NAME_TYPE) || $this->stream->current->test(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::NUMBER_TYPE)) {
                $key = new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\ConstantNode($this->stream->current->value);
                $this->stream->next();
            } elseif ($this->stream->current->test(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, '(')) {
                $key = $this->parseExpression();
            } else {
                $current = $this->stream->current;
                throw new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\SyntaxError(\sprintf('A hash key must be a quoted string, a number, a name, or an expression enclosed in parentheses (unexpected token "%s" of value "%s".', $current->type, $current->value), $current->cursor, $this->stream->getExpression());
            }
            $this->stream->expect(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, ':', 'A hash key must be followed by a colon (:)');
            $value = $this->parseExpression();
            $node->addElement($value, $key);
        }
        $this->stream->expect(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, '}', 'An opened hash is not properly closed');
        return $node;
    }
    public function parsePostfixExpression(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\Node $node)
    {
        $token = $this->stream->current;
        while (\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE == $token->type) {
            if ('.' === $token->value) {
                $this->stream->next();
                $token = $this->stream->current;
                $this->stream->next();
                if (\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::NAME_TYPE !== $token->type && (\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::OPERATOR_TYPE !== $token->type || !\preg_match('/[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*/A', $token->value))) {
                    throw new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\SyntaxError('Expected name.', $token->cursor, $this->stream->getExpression());
                }
                $arg = new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\ConstantNode($token->value, \true);
                $arguments = new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\ArgumentsNode();
                if ($this->stream->current->test(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, '(')) {
                    $type = \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\GetAttrNode::METHOD_CALL;
                    foreach ($this->parseArguments()->nodes as $n) {
                        $arguments->addElement($n);
                    }
                } else {
                    $type = \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\GetAttrNode::PROPERTY_CALL;
                }
                $node = new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\GetAttrNode($node, $arg, $arguments, $type);
            } elseif ('[' === $token->value) {
                $this->stream->next();
                $arg = $this->parseExpression();
                $this->stream->expect(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, ']');
                $node = new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\GetAttrNode($node, $arg, new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\ArgumentsNode(), \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\GetAttrNode::ARRAY_CALL);
            } else {
                break;
            }
            $token = $this->stream->current;
        }
        return $node;
    }
    /**
     * Parses arguments.
     */
    public function parseArguments()
    {
        $args = [];
        $this->stream->expect(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, '(', 'A list of arguments must begin with an opening parenthesis');
        while (!$this->stream->current->test(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, ')')) {
            if (!empty($args)) {
                $this->stream->expect(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, ',', 'Arguments must be separated by a comma');
            }
            $args[] = $this->parseExpression();
        }
        $this->stream->expect(\ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Token::PUNCTUATION_TYPE, ')', 'A list of arguments must be closed by a parenthesis');
        return new \ConfigTransformer202205147\Symfony\Component\ExpressionLanguage\Node\Node($args);
    }
}
