<?php

declare (strict_types=1);
namespace ConfigTransformer20210606\PhpParser;

/**
 * @codeCoverageIgnore
 */
class NodeVisitorAbstract implements \ConfigTransformer20210606\PhpParser\NodeVisitor
{
    public function beforeTraverse(array $nodes)
    {
        return null;
    }
    public function enterNode(\ConfigTransformer20210606\PhpParser\Node $node)
    {
        return null;
    }
    public function leaveNode(\ConfigTransformer20210606\PhpParser\Node $node)
    {
        return null;
    }
    public function afterTraverse(array $nodes)
    {
        return null;
    }
}
