<?php

declare (strict_types=1);
namespace ConfigTransformer2021120610\PhpParser\NodeVisitor;

use ConfigTransformer2021120610\PhpParser\Node;
use ConfigTransformer2021120610\PhpParser\NodeVisitorAbstract;
/**
 * Visitor cloning all nodes and linking to the original nodes using an attribute.
 *
 * This visitor is required to perform format-preserving pretty prints.
 */
class CloningVisitor extends \ConfigTransformer2021120610\PhpParser\NodeVisitorAbstract
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
