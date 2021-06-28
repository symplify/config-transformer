<?php

declare (strict_types=1);
namespace ConfigTransformer202106282\Symplify\Astral\Contract;

use ConfigTransformer202106282\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202106282\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202106282\PhpParser\Node $node) : ?string;
}
