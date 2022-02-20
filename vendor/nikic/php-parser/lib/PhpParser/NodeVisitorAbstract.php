<?php

declare (strict_types=1);
namespace ConfigTransformer202202207\PhpParser;

/**
 * @codeCoverageIgnore
 */
class NodeVisitorAbstract implements \ConfigTransformer202202207\PhpParser\NodeVisitor
{
    public function beforeTraverse(array $nodes)
    {
        return null;
    }
    public function enterNode(\ConfigTransformer202202207\PhpParser\Node $node)
    {
        return null;
    }
    public function leaveNode(\ConfigTransformer202202207\PhpParser\Node $node)
    {
        return null;
    }
    public function afterTraverse(array $nodes)
    {
        return null;
    }
}
