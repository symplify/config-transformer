<?php

declare (strict_types=1);
namespace ConfigTransformer202202029\Symplify\Astral\Contract;

use ConfigTransformer202202029\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202202029\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202202029\PhpParser\Node $node) : ?string;
}
