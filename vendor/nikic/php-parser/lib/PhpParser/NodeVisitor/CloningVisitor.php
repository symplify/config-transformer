<?php

declare (strict_types=1);
namespace ConfigTransformer202202191\PhpParser\NodeVisitor;

use ConfigTransformer202202191\PhpParser\Node;
use ConfigTransformer202202191\PhpParser\NodeVisitorAbstract;
/**
 * Visitor cloning all nodes and linking to the original nodes using an attribute.
 *
 * This visitor is required to perform format-preserving pretty prints.
 */
class CloningVisitor extends \ConfigTransformer202202191\PhpParser\NodeVisitorAbstract
{
    public function enterNode(\ConfigTransformer202202191\PhpParser\Node $origNode)
    {
        $node = clone $origNode;
        $node->setAttribute('origNode', $origNode);
        return $node;
    }
}
