<?php

declare (strict_types=1);
namespace ConfigTransformer202204164\Symplify\Astral\Contract;

use ConfigTransformer202204164\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202204164\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202204164\PhpParser\Node $node) : ?string;
}
