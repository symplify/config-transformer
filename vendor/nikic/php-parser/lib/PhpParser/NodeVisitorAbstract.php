<?php

declare (strict_types=1);
namespace ConfigTransformer202106282\PhpParser;

/**
 * @codeCoverageIgnore
 */
class NodeVisitorAbstract implements \ConfigTransformer202106282\PhpParser\NodeVisitor
{
    public function beforeTraverse(array $nodes)
    {
        return null;
    }
    public function enterNode(\ConfigTransformer202106282\PhpParser\Node $node)
    {
        return null;
    }
    public function leaveNode(\ConfigTransformer202106282\PhpParser\Node $node)
    {
        return null;
    }
    public function afterTraverse(array $nodes)
    {
        return null;
    }
}
