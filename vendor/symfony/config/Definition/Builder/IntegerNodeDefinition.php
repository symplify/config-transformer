<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2021122310\Symfony\Component\Config\Definition\Builder;

use ConfigTransformer2021122310\Symfony\Component\Config\Definition\IntegerNode;
/**
 * This class provides a fluent interface for defining an integer node.
 *
 * @author Jeanmonod David <david.jeanmonod@gmail.com>
 */
class IntegerNodeDefinition extends \ConfigTransformer2021122310\Symfony\Component\Config\Definition\Builder\NumericNodeDefinition
{
    /**
     * Instantiates a Node.
     */
    protected function instantiateNode() : \ConfigTransformer2021122310\Symfony\Component\Config\Definition\ScalarNode
    {
        return new \ConfigTransformer2021122310\Symfony\Component\Config\Definition\IntegerNode($this->name, $this->parent, $this->min, $this->max, $this->pathSeparator);
    }
}
