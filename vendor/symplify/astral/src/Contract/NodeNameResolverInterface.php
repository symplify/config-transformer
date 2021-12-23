<?php

declare (strict_types=1);
namespace ConfigTransformer202112237\Symplify\Astral\Contract;

use ConfigTransformer202112237\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202112237\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202112237\PhpParser\Node $node) : ?string;
}
