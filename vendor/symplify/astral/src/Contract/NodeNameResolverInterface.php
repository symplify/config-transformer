<?php

declare (strict_types=1);
namespace ConfigTransformer202106123\Symplify\Astral\Contract;

use ConfigTransformer202106123\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202106123\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202106123\PhpParser\Node $node) : ?string;
}
