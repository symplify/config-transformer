<?php

declare (strict_types=1);
namespace ConfigTransformer202106287\Symplify\Astral\Contract;

use ConfigTransformer202106287\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202106287\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202106287\PhpParser\Node $node) : ?string;
}
