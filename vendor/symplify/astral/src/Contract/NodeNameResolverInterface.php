<?php

declare (strict_types=1);
namespace ConfigTransformer202206048\Symplify\Astral\Contract;

use ConfigTransformer202206048\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202206048\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202206048\PhpParser\Node $node) : ?string;
}
