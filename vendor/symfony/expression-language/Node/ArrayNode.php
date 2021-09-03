<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202109039\Symfony\Component\ExpressionLanguage\Node;

use ConfigTransformer202109039\Symfony\Component\ExpressionLanguage\Compiler;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @internal
 */
class ArrayNode extends \ConfigTransformer202109039\Symfony\Component\ExpressionLanguage\Node\Node
{
    protected $index;
    public function __construct()
    {
        $this->index = -1;
    }
    /**
     * @param \Symfony\Component\ExpressionLanguage\Node\Node $value
     * @param \Symfony\Component\ExpressionLanguage\Node\Node|null $key
     */
    public function addElement($value, $key = null)
    {
        if (null === $key) {
            $key = new \ConfigTransformer202109039\Symfony\Component\ExpressionLanguage\Node\ConstantNode(++$this->index);
        }
        \array_push($this->nodes, $key, $value);
    }
    /**
     * Compiles the node to PHP.
     * @param \Symfony\Component\ExpressionLanguage\Compiler $compiler
     */
    public function compile($compiler)
    {
        $compiler->raw('[');
        $this->compileArguments($compiler);
        $compiler->raw(']');
    }
    /**
     * @param mixed[] $functions
     * @param mixed[] $values
     */
    public function evaluate($functions, $values)
    {
        $result = [];
        foreach ($this->getKeyValuePairs() as $pair) {
            $result[$pair['key']->evaluate($functions, $values)] = $pair['value']->evaluate($functions, $values);
        }
        return $result;
    }
    public function toArray()
    {
        $value = [];
        foreach ($this->getKeyValuePairs() as $pair) {
            $value[$pair['key']->attributes['value']] = $pair['value'];
        }
        $array = [];
        if ($this->isHash($value)) {
            foreach ($value as $k => $v) {
                $array[] = ', ';
                $array[] = new \ConfigTransformer202109039\Symfony\Component\ExpressionLanguage\Node\ConstantNode($k);
                $array[] = ': ';
                $array[] = $v;
            }
            $array[0] = '{';
            $array[] = '}';
        } else {
            foreach ($value as $v) {
                $array[] = ', ';
                $array[] = $v;
            }
            $array[0] = '[';
            $array[] = ']';
        }
        return $array;
    }
    protected function getKeyValuePairs()
    {
        $pairs = [];
        foreach (\array_chunk($this->nodes, 2) as $pair) {
            $pairs[] = ['key' => $pair[0], 'value' => $pair[1]];
        }
        return $pairs;
    }
    /**
     * @param \Symfony\Component\ExpressionLanguage\Compiler $compiler
     * @param bool $withKeys
     */
    protected function compileArguments($compiler, $withKeys = \true)
    {
        $first = \true;
        foreach ($this->getKeyValuePairs() as $pair) {
            if (!$first) {
                $compiler->raw(', ');
            }
            $first = \false;
            if ($withKeys) {
                $compiler->compile($pair['key'])->raw(' => ');
            }
            $compiler->compile($pair['value']);
        }
    }
}
