<?php

declare (strict_types=1);
namespace ConfigTransformer202106110\PhpParser;

/**
 * @codeCoverageIgnore
 */
class NodeVisitorAbstract implements \ConfigTransformer202106110\PhpParser\NodeVisitor
{
    public function beforeTraverse(array $nodes)
    {
        return null;
    }
    public function enterNode(\ConfigTransformer202106110\PhpParser\Node $node)
    {
        return null;
    }
    public function leaveNode(\ConfigTransformer202106110\PhpParser\Node $node)
    {
        return null;
    }
    public function afterTraverse(array $nodes)
    {
        return null;
    }
}
