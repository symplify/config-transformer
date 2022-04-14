<?php

declare (strict_types=1);
namespace ConfigTransformer2022041410\PhpParser;

/**
 * @codeCoverageIgnore
 */
class NodeVisitorAbstract implements \ConfigTransformer2022041410\PhpParser\NodeVisitor
{
    public function beforeTraverse(array $nodes)
    {
        return null;
    }
    public function enterNode(\ConfigTransformer2022041410\PhpParser\Node $node)
    {
        return null;
    }
    public function leaveNode(\ConfigTransformer2022041410\PhpParser\Node $node)
    {
        return null;
    }
    public function afterTraverse(array $nodes)
    {
        return null;
    }
}
