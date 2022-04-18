<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202204182\Symfony\Component\ExpressionLanguage;

/**
 * Represents a token stream.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class TokenStream
{
    public $current;
    /**
     * @var mixed[]
     */
    private $tokens;
    /**
     * @var int
     */
    private $position = 0;
    /**
     * @var string
     */
    private $expression;
    public function __construct(array $tokens, string $expression = '')
    {
        $this->tokens = $tokens;
        $this->current = $tokens[0];
        $this->expression = $expression;
    }
    /**
     * Returns a string representation of the token stream.
     */
    public function __toString() : string
    {
        return \implode("\n", $this->tokens);
    }
    /**
     * Sets the pointer to the next token and returns the old one.
     */
    public function next()
    {
        ++$this->position;
        if (!isset($this->tokens[$this->position])) {
            throw new \ConfigTransformer202204182\Symfony\Component\ExpressionLanguage\SyntaxError('Unexpected end of expression.', $this->current->cursor, $this->expression);
        }
        $this->current = $this->tokens[$this->position];
    }
    /**
     * @param string|null $message The syntax error message
     */
    public function expect(string $type, string $value = null, string $message = null)
    {
        $token = $this->current;
        if (!$token->test($type, $value)) {
            throw new \ConfigTransformer202204182\Symfony\Component\ExpressionLanguage\SyntaxError(\sprintf('%sUnexpected token "%s" of value "%s" ("%s" expected%s).', $message ? $message . '. ' : '', $token->type, $token->value, $type, $value ? \sprintf(' with value "%s"', $value) : ''), $token->cursor, $this->expression);
        }
        $this->next();
    }
    /**
     * Checks if end of stream was reached.
     */
    public function isEOF() : bool
    {
        return \ConfigTransformer202204182\Symfony\Component\ExpressionLanguage\Token::EOF_TYPE === $this->current->type;
    }
    /**
     * @internal
     */
    public function getExpression() : string
    {
        return $this->expression;
    }
}
