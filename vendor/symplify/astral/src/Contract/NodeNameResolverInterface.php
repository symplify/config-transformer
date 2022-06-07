<?php

declare (strict_types=1);
namespace ConfigTransformer202206077\Symplify\Astral\Contract;

use ConfigTransformer202206077\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(Node $node) : bool;
    public function resolve(Node $node) : ?string;
}
