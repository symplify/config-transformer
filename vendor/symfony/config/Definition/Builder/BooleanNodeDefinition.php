<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Symfony\Component\Config\Definition\Builder;

use Symfony\Component\Config\Definition\BooleanNode;
use Symfony\Component\Config\Definition\Exception\InvalidDefinitionException;
/**
 * This class provides a fluent interface for defining a node.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class BooleanNodeDefinition extends \Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition
{
    public function __construct(?string $name, \Symfony\Component\Config\Definition\Builder\NodeParentInterface $parent = null)
    {
        parent::__construct($name, $parent);
        $this->nullEquivalent = \true;
    }
    /**
     * Instantiate a Node.
     */
    protected function instantiateNode() : \Symfony\Component\Config\Definition\ScalarNode
    {
        return new BooleanNode($this->name, $this->parent, $this->pathSeparator);
    }
    /**
     * @throws InvalidDefinitionException
     * @return static
     */
    public function cannotBeEmpty()
    {
        throw new InvalidDefinitionException('->cannotBeEmpty() is not applicable to BooleanNodeDefinition.');
    }
}
