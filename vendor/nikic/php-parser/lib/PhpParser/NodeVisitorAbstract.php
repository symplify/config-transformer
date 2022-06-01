<?php

declare (strict_types=1);
namespace ConfigTransformer202206013\PhpParser;

/**
 * @codeCoverageIgnore
 */
class NodeVisitorAbstract implements \ConfigTransformer202206013\PhpParser\NodeVisitor
{
    public function beforeTraverse(array $nodes)
    {
        return null;
    }
    public function enterNode(\ConfigTransformer202206013\PhpParser\Node $node)
    {
        return null;
    }
    public function leaveNode(\ConfigTransformer202206013\PhpParser\Node $node)
    {
        return null;
    }
    public function afterTraverse(array $nodes)
    {
        return null;
    }
}
