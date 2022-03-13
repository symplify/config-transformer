<?php

declare (strict_types=1);
namespace ConfigTransformer202203132\Symplify\Astral\Contract;

use ConfigTransformer202203132\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202203132\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202203132\PhpParser\Node $node) : ?string;
}
