<?php

declare (strict_types=1);
namespace ConfigTransformer20210610\PhpParser;

/**
 * @codeCoverageIgnore
 */
class NodeVisitorAbstract implements \ConfigTransformer20210610\PhpParser\NodeVisitor
{
    public function beforeTraverse(array $nodes)
    {
        return null;
    }
    public function enterNode(\ConfigTransformer20210610\PhpParser\Node $node)
    {
        return null;
    }
    public function leaveNode(\ConfigTransformer20210610\PhpParser\Node $node)
    {
        return null;
    }
    public function afterTraverse(array $nodes)
    {
        return null;
    }
}
