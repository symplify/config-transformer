<?php

declare (strict_types=1);
namespace ConfigTransformer2021061810\PhpParser;

/**
 * @codeCoverageIgnore
 */
class NodeVisitorAbstract implements \ConfigTransformer2021061810\PhpParser\NodeVisitor
{
    public function beforeTraverse(array $nodes)
    {
        return null;
    }
    public function enterNode(\ConfigTransformer2021061810\PhpParser\Node $node)
    {
        return null;
    }
    public function leaveNode(\ConfigTransformer2021061810\PhpParser\Node $node)
    {
        return null;
    }
    public function afterTraverse(array $nodes)
    {
        return null;
    }
}
