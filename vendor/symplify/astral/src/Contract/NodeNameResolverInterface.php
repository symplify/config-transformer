<?php

declare (strict_types=1);
namespace ConfigTransformer202206065\Symplify\Astral\Contract;

use ConfigTransformer202206065\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202206065\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202206065\PhpParser\Node $node) : ?string;
}
