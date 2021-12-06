<?php

declare (strict_types=1);
namespace ConfigTransformer2021120610\Symplify\Astral\Contract;

use ConfigTransformer2021120610\PhpParser\Node;
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
