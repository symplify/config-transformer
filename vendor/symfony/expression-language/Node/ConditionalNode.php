<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202107105\Symfony\Component\ExpressionLanguage\Node;

use ConfigTransformer202107105\Symfony\Component\ExpressionLanguage\Compiler;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @internal
 */
class ConditionalNode extends \ConfigTransformer202107105\Symfony\Component\ExpressionLanguage\Node\Node
{
    public function __construct(\ConfigTransformer202107105\Symfony\Component\ExpressionLanguage\Node\Node $expr1, \ConfigTransformer202107105\Symfony\Component\ExpressionLanguage\Node\Node $expr2, \ConfigTransformer202107105\Symfony\Component\ExpressionLanguage\Node\Node $expr3)
    {
        parent::__construct(['expr1' => $expr1, 'expr2' => $expr2, 'expr3' => $expr3]);
    }
    /**
     * @param \Symfony\Component\ExpressionLanguage\Compiler $compiler
     */
    public function compile($compiler)
    {
        $compiler->raw('((')->compile($this->nodes['expr1'])->raw(') ? (')->compile($this->nodes['expr2'])->raw(') : (')->compile($this->nodes['expr3'])->raw('))');
    }
    /**
     * @param mixed[] $functions
     * @param mixed[] $values
     */
    public function evaluate($functions, $values)
    {
        if ($this->nodes['expr1']->evaluate($functions, $values)) {
            return $this->nodes['expr2']->evaluate($functions, $values);
        }
        return $this->nodes['expr3']->evaluate($functions, $values);
    }
    public function toArray()
    {
        return ['(', $this->nodes['expr1'], ' ? ', $this->nodes['expr2'], ' : ', $this->nodes['expr3'], ')'];
    }
}
