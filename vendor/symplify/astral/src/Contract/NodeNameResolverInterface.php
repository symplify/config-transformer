<?php

declare (strict_types=1);
namespace ConfigTransformer2021082410\Symplify\Astral\Contract;

use ConfigTransformer2021082410\PhpParser\Node;
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
