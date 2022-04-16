<?php

declare (strict_types=1);
namespace ConfigTransformer202204162\Symplify\Astral\Contract;

use ConfigTransformer202204162\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202204162\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202204162\PhpParser\Node $node) : ?string;
}
