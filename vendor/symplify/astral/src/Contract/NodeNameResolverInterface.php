<?php

declare (strict_types=1);
namespace ConfigTransformer202109307\Symplify\Astral\Contract;

use ConfigTransformer202109307\PhpParser\Node;
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
