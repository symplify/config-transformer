<?php

declare (strict_types=1);
namespace ConfigTransformer202111211\Symplify\Astral\Contract;

use ConfigTransformer202111211\PhpParser\Node;
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
