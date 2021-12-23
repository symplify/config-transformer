<?php

declare (strict_types=1);
namespace ConfigTransformer2021122310\PhpParser;

/**
 * @codeCoverageIgnore
 */
class NodeVisitorAbstract implements \ConfigTransformer2021122310\PhpParser\NodeVisitor
{
    public function beforeTraverse(array $nodes)
    {
        return null;
    }
    public function enterNode(\ConfigTransformer2021122310\PhpParser\Node $node)
    {
        return null;
    }
    public function leaveNode(\ConfigTransformer2021122310\PhpParser\Node $node)
    {
        return null;
    }
    public function afterTraverse(array $nodes)
    {
        return null;
    }
}
