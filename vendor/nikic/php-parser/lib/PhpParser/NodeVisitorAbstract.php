<?php

declare (strict_types=1);
namespace ConfigTransformer202201236\PhpParser;

/**
 * @codeCoverageIgnore
 */
class NodeVisitorAbstract implements \ConfigTransformer202201236\PhpParser\NodeVisitor
{
    public function beforeTraverse(array $nodes)
    {
        return null;
    }
    public function enterNode(\ConfigTransformer202201236\PhpParser\Node $node)
    {
        return null;
    }
    public function leaveNode(\ConfigTransformer202201236\PhpParser\Node $node)
    {
        return null;
    }
    public function afterTraverse(array $nodes)
    {
        return null;
    }
}
