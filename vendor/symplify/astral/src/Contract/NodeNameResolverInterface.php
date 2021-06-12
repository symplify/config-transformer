<?php

declare (strict_types=1);
namespace ConfigTransformer202106121\Symplify\Astral\Contract;

use ConfigTransformer202106121\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202106121\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202106121\PhpParser\Node $node) : ?string;
}
