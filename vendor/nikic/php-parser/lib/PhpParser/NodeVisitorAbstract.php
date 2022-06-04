<?php

declare (strict_types=1);
namespace ConfigTransformer202206045\PhpParser;

/**
 * @codeCoverageIgnore
 */
class NodeVisitorAbstract implements \ConfigTransformer202206045\PhpParser\NodeVisitor
{
    public function beforeTraverse(array $nodes)
    {
        return null;
    }
    public function enterNode(\ConfigTransformer202206045\PhpParser\Node $node)
    {
        return null;
    }
    public function leaveNode(\ConfigTransformer202206045\PhpParser\Node $node)
    {
        return null;
    }
    public function afterTraverse(array $nodes)
    {
        return null;
    }
}
