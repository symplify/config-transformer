<?php

declare (strict_types=1);
namespace ConfigTransformer202202024\Symplify\Astral\Contract;

use ConfigTransformer202202024\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202202024\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202202024\PhpParser\Node $node) : ?string;
}
