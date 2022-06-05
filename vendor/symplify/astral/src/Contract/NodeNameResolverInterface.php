<?php

declare (strict_types=1);
namespace ConfigTransformer202206055\Symplify\Astral\Contract;

use ConfigTransformer202206055\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202206055\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202206055\PhpParser\Node $node) : ?string;
}
