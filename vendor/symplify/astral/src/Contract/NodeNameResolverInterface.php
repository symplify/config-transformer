<?php

declare (strict_types=1);
namespace ConfigTransformer202206021\Symplify\Astral\Contract;

use ConfigTransformer202206021\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202206021\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202206021\PhpParser\Node $node) : ?string;
}
