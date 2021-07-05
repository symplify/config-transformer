<?php

declare (strict_types=1);
namespace ConfigTransformer2021070510\PhpParser;

/**
 * @codeCoverageIgnore
 */
class NodeVisitorAbstract implements \ConfigTransformer2021070510\PhpParser\NodeVisitor
{
    public function beforeTraverse(array $nodes)
    {
        return null;
    }
    public function enterNode(\ConfigTransformer2021070510\PhpParser\Node $node)
    {
        return null;
    }
    public function leaveNode(\ConfigTransformer2021070510\PhpParser\Node $node)
    {
        return null;
    }
    public function afterTraverse(array $nodes)
    {
        return null;
    }
}
