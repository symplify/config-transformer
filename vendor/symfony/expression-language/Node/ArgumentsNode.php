<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202110018\Symfony\Component\ExpressionLanguage\Node;

use ConfigTransformer202110018\Symfony\Component\ExpressionLanguage\Compiler;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @internal
 */
class ArgumentsNode extends \ConfigTransformer202110018\Symfony\Component\ExpressionLanguage\Node\ArrayNode
{
    /**
     * @param \Symfony\Component\ExpressionLanguage\Compiler $compiler
     */
    public function compile($compiler)
    {
        $this->compileArguments($compiler, \false);
    }
    public function toArray()
    {
        $array = [];
        foreach ($this->getKeyValuePairs() as $pair) {
            $array[] = $pair['value'];
            $array[] = ', ';
        }
        \array_pop($array);
        return $array;
    }
}
