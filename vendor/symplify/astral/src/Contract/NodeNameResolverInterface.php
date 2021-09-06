<?php

declare (strict_types=1);
namespace ConfigTransformer2021090610\Symplify\Astral\Contract;

use ConfigTransformer2021090610\PhpParser\Node;
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
