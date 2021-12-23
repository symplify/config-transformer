<?php

declare (strict_types=1);
namespace ConfigTransformer202112238\Symplify\Astral\Contract;

use ConfigTransformer202112238\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202112238\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202112238\PhpParser\Node $node) : ?string;
}
