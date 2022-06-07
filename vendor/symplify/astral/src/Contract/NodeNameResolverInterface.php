<?php

declare (strict_types=1);
namespace ConfigTransformer202206075\Symplify\Astral\Contract;

use ConfigTransformer202206075\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(Node $node) : bool;
    public function resolve(Node $node) : ?string;
}
