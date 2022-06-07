<?php

declare (strict_types=1);
namespace ConfigTransformer202206079\Symplify\Astral\Contract;

use ConfigTransformer202206079\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(Node $node) : bool;
    public function resolve(Node $node) : ?string;
}
