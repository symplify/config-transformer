<?php

declare (strict_types=1);
namespace ConfigTransformer202202206\Symplify\Astral\Contract;

use ConfigTransformer202202206\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202202206\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202202206\PhpParser\Node $node) : ?string;
}
