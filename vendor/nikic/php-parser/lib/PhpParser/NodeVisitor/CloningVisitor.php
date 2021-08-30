<?php

declare (strict_types=1);
namespace ConfigTransformer202108306\PhpParser\NodeVisitor;

use ConfigTransformer202108306\PhpParser\Node;
use ConfigTransformer202108306\PhpParser\NodeVisitorAbstract;
/**
 * Visitor cloning all nodes and linking to the original nodes using an attribute.
 *
 * This visitor is required to perform format-preserving pretty prints.
 */
class CloningVisitor extends \ConfigTransformer202108306\PhpParser\NodeVisitorAbstract
{
    /**
     * @param \PhpParser\Node $origNode
     */
    public function enterNode($origNode)
    {
        $node = clone $origNode;
        $node->setAttribute('origNode', $origNode);
        return $node;
    }
}
