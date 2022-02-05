<?php

declare (strict_types=1);
namespace ConfigTransformer202202050\Symplify\Astral\Contract;

use ConfigTransformer202202050\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202202050\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202202050\PhpParser\Node $node) : ?string;
}
