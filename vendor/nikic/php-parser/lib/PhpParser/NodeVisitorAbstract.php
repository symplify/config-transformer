<?php

declare (strict_types=1);
namespace ConfigTransformer202106125\PhpParser;

/**
 * @codeCoverageIgnore
 */
class NodeVisitorAbstract implements \ConfigTransformer202106125\PhpParser\NodeVisitor
{
    public function beforeTraverse(array $nodes)
    {
        return null;
    }
    public function enterNode(\ConfigTransformer202106125\PhpParser\Node $node)
    {
        return null;
    }
    public function leaveNode(\ConfigTransformer202106125\PhpParser\Node $node)
    {
        return null;
    }
    public function afterTraverse(array $nodes)
    {
        return null;
    }
}
