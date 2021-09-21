<?php

declare (strict_types=1);
namespace ConfigTransformer202109217\Symplify\Astral\Contract;

use ConfigTransformer202109217\PhpParser\Node;
interface NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool;
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string;
}
