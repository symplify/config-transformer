<?php

declare (strict_types=1);
namespace ConfigTransformer202106194\Symplify\Astral\Contract;

use ConfigTransformer202106194\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202106194\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202106194\PhpParser\Node $node) : ?string;
}
