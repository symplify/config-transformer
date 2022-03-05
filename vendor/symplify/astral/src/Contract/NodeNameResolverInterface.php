<?php

declare (strict_types=1);
namespace ConfigTransformer202203055\Symplify\Astral\Contract;

use ConfigTransformer202203055\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202203055\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202203055\PhpParser\Node $node) : ?string;
}
