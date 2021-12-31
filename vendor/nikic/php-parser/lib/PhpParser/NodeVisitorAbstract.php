<?php

declare (strict_types=1);
namespace ConfigTransformer202112315\PhpParser;

/**
 * @codeCoverageIgnore
 */
class NodeVisitorAbstract implements \ConfigTransformer202112315\PhpParser\NodeVisitor
{
    public function beforeTraverse(array $nodes)
    {
        return null;
    }
    public function enterNode(\ConfigTransformer202112315\PhpParser\Node $node)
    {
        return null;
    }
    public function leaveNode(\ConfigTransformer202112315\PhpParser\Node $node)
    {
        return null;
    }
    public function afterTraverse(array $nodes)
    {
        return null;
    }
}
