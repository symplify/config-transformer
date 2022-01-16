<?php

declare (strict_types=1);
namespace ConfigTransformer202201160\PhpParser\NodeVisitor;

use ConfigTransformer202201160\PhpParser\Node;
use ConfigTransformer202201160\PhpParser\NodeVisitorAbstract;
/**
 * Visitor cloning all nodes and linking to the original nodes using an attribute.
 *
 * This visitor is required to perform format-preserving pretty prints.
 */
class CloningVisitor extends \ConfigTransformer202201160\PhpParser\NodeVisitorAbstract
{
    public function enterNode(\ConfigTransformer202201160\PhpParser\Node $origNode)
    {
        $node = clone $origNode;
        $node->setAttribute('origNode', $origNode);
        return $node;
    }
}
