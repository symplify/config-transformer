<?php

declare (strict_types=1);
namespace ConfigTransformer202106207\Symplify\Astral\Contract;

use ConfigTransformer202106207\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202106207\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202106207\PhpParser\Node $node) : ?string;
}
