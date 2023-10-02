<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202310\Symfony\Component\ExpressionLanguage\Node;

use ConfigTransformerPrefix202310\Symfony\Component\ExpressionLanguage\Compiler;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @internal
 */
class UnaryNode extends Node
{
    private const OPERATORS = ['!' => '!', 'not' => '!', '+' => '+', '-' => '-'];
    public function __construct(string $operator, Node $node)
    {
        parent::__construct(['node' => $node], ['operator' => $operator]);
    }
    public function compile(Compiler $compiler) : void
    {
        $compiler->raw('(')->raw(self::OPERATORS[$this->attributes['operator']])->compile($this->nodes['node'])->raw(')');
    }
    /**
     * @return mixed
     */
    public function evaluate(array $functions, array $values)
    {
        $value = $this->nodes['node']->evaluate($functions, $values);
        switch ($this->attributes['operator']) {
            case 'not':
            case '!':
                return !$value;
            case '-':
                return -$value;
            default:
                return $value;
        }
    }
    public function toArray() : array
    {
        return ['(', $this->attributes['operator'] . ' ', $this->nodes['node'], ')'];
    }
}
